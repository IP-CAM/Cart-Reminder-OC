<?php
class ControllerExtensionModuleCartReminder extends Controller {
    public function index() {
        $this->load->language('extension/module/cart_reminder'); // loads the language file of cart reminder
         
        $data['cartreminder_button_value'] = $this->language->get('cartreminder_button_value'); // set the heading_title of the module
         
        $data['cartreminder_label_value'] = html_entity_decode($this->config->get('cart_reminder_textarea')); // gets the saved value of the text field and parses it to a variable to use this inside our module view
        
		$data['cart'] = $this->cart->getProducts();
		
		$data['urlredirect'] = $this->url->link('checkout/cart');
		
        return $this->load->view('extension/module/cart_reminder', $data);
    }
}