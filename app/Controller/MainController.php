<?php
/**
 * Main Controller
 *
 * app/Controller/MainController.php
 */

class MainController extends AppController {
  
  function index2() {
    $this->set('str',$this->Website->get_all());
  }

  function index() {
    if ($this->request->is('post')) {
      $this->Website->read(null, $_POST['id_hidden']);
      $this->Website->set(array(
        'address' => $_POST['address'],
        'phoneNumber' => $_POST['phone'],
        'desc' => $_POST['description'],
        'category' => 'shoes',
        'email' => $_POST['email']
      ));
      $this->Website->save();
    }

    $site = $this->Website->find('first',array('conditions'=>array('desc'=>null)));
    $url = $site['Website']['name'];
    $this->set('web_id', $site['Website']['id']);
    
    $html = get_html('www.'.$url);
      
    $this->set('desc', get_description($html));
    $phone = get_phone($html);
    $email = get_email($html);
    $tags = get_tags($html);
    $address = [];
    
    $contact_links = get_contact_links($html);
    foreach($contact_links as $xal) {
      $phone = array_unique(array_merge($phone, get_phone(get_html($url . $xal))));
      $email = array_unique(array_merge($email, get_phone(get_html($url . $xal))));
      $tags = array_unique(array_merge($tags, get_phone(get_html($url . $xal))));
    }
    
    /*
     * Look for Orders and Returns
     * Look for FAQ
     * Delivery and Returns
     */
    
    $this->set('tags', $tags);
    $this->set('contact_info', ['phone'=>$phone,'address'=>$address,'email'=>$email,'links'=>$contact_links]);
      
    $this->set('html',$html);
    $this->set('url',$url);
    
  }

  function quiz() {}
  
}