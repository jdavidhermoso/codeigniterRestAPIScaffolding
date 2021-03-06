<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model("Your_model");
  }

  public function index()
  {

  }

  public function items()
  {
    switch ($this->getRequestType()) {
      case 'get':
        $this->searchItems();
        break;
      case 'post':
        $this->addItem();
        break;
      case 'delete':
        $this->deleteItem();
        break;
    }
  }

  private function searchItems()
  {
    $id = $this->uri->segment(3);
    $result = $this->Your_model->getItems($id);
    echo json_encode($result);
  }

  private function addItem()
  {
    $post_params = $this->get_post();
    $title = $post_params['title'];
    $author = $post_params['author'];
    $coverImage = $post_params['coverImage'];

    $this->Your_model->insertItem($title, $author, $coverImage);

    $response = array('status' => 'OK');

    $this->output
      ->set_status_header(200)
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
      ->_display();
    exit;
  }

  private function deleteItem()
  {
    $id = $this->uri->segment(3);
    echo $this->Your_model->deleteItem($id);
  }

  private function getRequestType()
  {
    return strtolower($this->input->server('REQUEST_METHOD'));
  }

  private function get_post() {
    $rest_json = file_get_contents("php://input");
    return json_decode($rest_json, true);
  }
}
