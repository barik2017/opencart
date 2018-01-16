<?php
class ModelCatalogPartnership extends Model{
    public function addPartner($our_array)
    {
        $sql = "INSERT INTO " . DB_PREFIX ."partnership
        SET name = '" . $this->db->escape($our_array['name']) . "',
        email = '" . $this->db-> escape($our_array['email']) . "',
        age = '" . (int) $our_array['age'] . "',
        company = '" . $this->db-> escape($our_array['company']) . "',
        tax_form = '" . $this->db-> escape($our_array['tax_form']) . "',
        comment = '" . $this->db-> escape($our_array['comment']) . "',
        file = '" . $this->db-> escape ($our_array['file']) . "',
        file1 = '" . $this->db-> escape ($our_array['file1']) . "'";

        $this->db->query($sql);

    }
}