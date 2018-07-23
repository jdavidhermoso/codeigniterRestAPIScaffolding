<?php

class Your_model extends CI_Model
{
  public function getItems($id = '')
  {
    $where = '';
    $limit = '';
    $itemsArr = [];
    $item = [];

    if ($id) {
      $where = 'WHERE id = ' . $id;
      $limit = 'LIMIT 1';
    }

    $itemsQuery = $this->db->query("SELECT id,prop1,prop2 FROM itemsTable " . $where . " ORDER BY id " . $limit);

    foreach ($itemsQuery->result() as $row) {
      $item['id'] = $row->id;
      $item['prop1'] = $row->prop1;
      $item['prop2'] = $row->prop2;

      array_push($itemsArr, $item);

      unset($item);
    }

    return $itemsArr;
  }

  public function insertItem($prop1 = '', $prop2 = '', $coverImage = '')
  {
    return $this->db->query("INSERT INTO itemsTable (prop1, prop2) VALUES ('$prop1', '$prop2')");
  }

  public function deleteItem($id)
  {
    return $this->db->query("DELETE FROM `itemsTable` WHERE `id` = " . $id);
  }

}

?>
