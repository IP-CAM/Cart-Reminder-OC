<?php
class ControllerExtensionModuleCartReminder extends Controller {
    private $error = array(); // This is used to set the errors, if any.
	
 	public function install() {
		$this->load->model('setting/setting');

		$settings['module_cart_reminder_status'] = 1;
		$settings['module_cart_reminder_width'] = 450;
		$settings['module_cart_reminder_height'] = 600;
		$settings['module_cart_reminder_color'] = 'black';

		$this->model_setting_setting->editSetting('module_cart_reminder', $settings);
	}
	
    public function index() {
        // Loading the language file of cart reminder
        $this->load->language('extension/module/cart_reminder'); 
     
	    // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
        $this->load->model('setting/setting');
		
        // Set the title of the page to the heading title in the Language file i.e., Hello World
        $this->document->setTitle($this->language->get('heading_title'));
     
		
        // Start If: Validates and check if data is coming by save (POST) method
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // Parse all the coming data to Setting Model to save it in database.
            $this->model_setting_setting->editSetting('module_cart_reminder', $this->request->post);
     
            // To display the success text on data save
            $this->session->data['success'] = $this->language->get('text_success');
     
            // Redirect to the Module Listing
           $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }
     
        // Assign the language data for parsing it to view
        $data['heading_title'] = $this->language->get('heading_title');
     
        $data['text_edit']    = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');      
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');
     
        $data['entry_code'] = $this->language->get('entry_code');
        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
     
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');
        
		
        // This Block returns the warning if any
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
     
        // This Block returns the error code if any
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }     
     
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		if (isset($this->error['color'])) {
			$data['error_color'] = $this->error['color'];
		} else {
			$data['error_color'] = '';
		}

        // Making of Breadcrumbs to be displayed on site
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => ' :: '
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('extension/module/cart_reminder', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => ' :: '
        );
          
        $data['action'] = $this->url->link('extension/module/cart_reminder', 'user_token=' . $this->session->data['user_token'], true); // URL to be directed when the save button is pressed
     
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true); // URL to be redirected when cancel button is pressed
			  
        // This block checks, if the textfield is set it parses it to view otherwise get the default 
        // textfield from the database and parse it
        if (isset($this->request->post['module_cart_reminder_textarea'])) {
            $data['module_cart_reminder_textarea'] = $this->request->post['module_cart_reminder_textarea'];
        } else {
            $data['module_cart_reminder_textarea'] = $this->config->get('module_cart_reminder_textarea');
        }   
         
        if (isset($this->request->post['module_cart_reminder_width'])) {
            $data['module_cart_reminder_width'] = $this->request->post['module_cart_reminder_width'];
        } else {
            $data['module_cart_reminder_width'] = $this->config->get('module_cart_reminder_width');
        } 
		
	    if (isset($this->request->post['module_cart_reminder_height'])) {
            $data['module_cart_reminder_height'] = $this->request->post['module_cart_reminder_height'];
        } else {
            $data['module_cart_reminder_height'] = $this->config->get('module_cart_reminder_height');
        } 
		 
		if (isset($this->request->post['module_cart_reminder_color'])) {
            $data['module_cart_reminder_color'] = $this->request->post['module_cart_reminder_color'];
        } else {
            $data['module_cart_reminder_color'] = $this->config->get('module_cart_reminder_color');
        } 

        // This block parses the status (enabled / disabled)
		if (isset($this->request->post['module_cart_reminder_status'])) {
			$data['module_cart_reminder_status'] = $this->request->post['module_cart_reminder_status'];
		} else {
			$data['module_cart_reminder_status'] = $this->config->get('module_cart_reminder_status');
		}

		
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/module/cart_reminder', $data));
    }
    /* Function that validates the data when Save Button is pressed */
    protected function validate() {
 
        // Block to check the user permission to manipulate the module
        if (!$this->user->hasPermission('modify', 'extension/module/cart_reminder')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
		if (!isset($this->request->post['module_cart_reminder_textarea'])) {
			$this->error['code'] = $this->language->get('error_code');
		}

		if (!isset($this->request->post['module_cart_reminder_width'])) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!isset($this->request->post['module_cart_reminder_height'])) {
			$this->error['height'] = $this->language->get('error_height');
		}

		if (!isset($this->request->post['module_cart_reminder_color'])) {
			$this->error['color'] = $this->language->get('error_color');
		}

        /* End Block*/
 
        // Block returns true if no error is found, else false if any error detected
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}