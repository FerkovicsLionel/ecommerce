<?php
if(!session_id()){
	session_start();
}

class Cart {
    protected $cart_contents = array();
    
    public function __construct(){
        $this->cart_contents = !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL;
		if ($this->cart_contents === NULL){
			$this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
		}
    }
    
	public function contents(){
		$cart = array_reverse($this->cart_contents);

		unset($cart['total_items']);
		unset($cart['cart_total']);

		return $cart;
	}
    
	public function get_item($row_id){
		return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$row_id]))
			? FALSE
			: $this->cart_contents[$row_id];
	}

	public function total_items(){
		return $this->cart_contents['total_items'];
	}

	public function total(){
		return $this->cart_contents['cart_total'];
	}
    
	public function insert($item = array()){
		if(!is_array($item) OR count($item) === 0){
			return FALSE;
		}else{
            if(!isset($item['id'], $item['name'], $item['ar'], $item['image'], $item['qty'])){
                return FALSE;
            }else{

                $item['qty'] = (float) $item['qty'];
                if($item['qty'] == 0){
                    return FALSE;
                }
                // prep the price
                $item['ar'] = (float) $item['ar'];
                // create a unique identifier for the item being inserted into the cart
				$idstring=$item['id'].$item['size'].$item['lenyomatszin'].$item['szoveg'];
				$category_id=$item['category_id'];
				$rowid = md5($idstring);
                // get quantity if it's already there and add it on
                $old_qty = isset($this->cart_contents[$rowid]['qty']) ? (int) $this->cart_contents[$rowid]['qty'] : 0;
                // re-create the entry with unique identifier and updated quantity
                $item['rowid'] = $rowid;
                $item['qty'] += $old_qty;
                $this->cart_contents[$rowid] = $item;
                
                // save Cart Item
                if($this->save_cart()){
                    return isset($rowid) ? $rowid : TRUE;
                }else{
                    return FALSE;
                }
            }
        }
	}
	public function update($item = array()){
		if (!is_array($item) OR count($item) === 0){
			return FALSE;
		}else{
			if (!isset($item['rowid'], $this->cart_contents[$item['rowid']])){
				return FALSE;
			}else{
				// prep the quantity
				if(isset($item['qty'])){
					$item['qty'] = (float) $item['qty'];
					// remove the item from the cart, if quantity is zero
					if ($item['qty'] == 0){
						unset($this->cart_contents[$item['rowid']]);
						return TRUE;
					}
				}
				
				// find updatable keys
				$keys = array_intersect(array_keys($this->cart_contents[$item['rowid']]), array_keys($item));
				// prep the price
				if(isset($item['ar'])){
					$item['ar'] = (float) $item['ar'];
				}
				// product id & name shouldn't be changed
				foreach(array_diff($keys, array('id', 'name')) as $key){
					$this->cart_contents[$item['rowid']][$key] = $item[$key];
				}
				// save cart data
				$this->save_cart();
				return TRUE;
			}
		}
	}
    
    /**
	 * Save the cart array to the session
	 * @return	bool
	 */
	protected function save_cart(){
		$this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0;
		foreach ($this->cart_contents as $key => $val){
			// make sure the array contains the proper indexes
			if(!is_array($val) OR !isset($val['ar'], $val['qty'])){
				continue;
			}
	 
			$this->cart_contents['cart_total'] += (($val['ar']) * $val['qty']);
			$this->cart_contents['total_items'] += $val['qty'];
			$this->cart_contents[$key]['subtotal'] = (($this->cart_contents[$key]['ar']) * $this->cart_contents[$key]['qty']);
		}
		if(count($this->cart_contents) <= 2){
			unset($_SESSION['cart_contents']);
			return FALSE;
		}else{
			$_SESSION['cart_contents'] = $this->cart_contents;
			return TRUE;
		}
    }
    
    /**
	 * Remove Item: Removes an item from the cart
	 * @param	int
	 * @return	bool
	 */
	 public function remove($row_id){
		// unset & save
		unset($this->cart_contents[$row_id]);
		$this->save_cart();
		return TRUE;
	 }
     
    /**
	 * Destroy the cart: Empties the cart and destroy the session
	 * @return	void
	 */
	public function destroy(){
		$this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
		unset($_SESSION['cart_contents']);
	}
}