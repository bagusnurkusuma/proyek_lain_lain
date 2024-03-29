<?php
function format_number($input_function)
{
    $result = number_format($input_function, 2, ',', '.');
    return $result;
}
//Mengambil Transaction Number
function get_transaction_number($input_function)
{
    include "../asset_default/koneksi.php";
    $input = array("body" => array("table_name" => "pos.point_of_sales", "transaction_name" => "point_of_sales", "created_by" => $input_function));
    $input = json_encode($input);
    $query = "SELECT settings.get_new_transaction_number_and_primary_key('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Mengambil Default
function get_default($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.get_default_for_point_of_sales('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Mengambil Detail Transaction Detail
function get_transaction_detail($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.list_point_of_sales_detail('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Mengambil Product List
function get_product_for_transaction($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.list_product_for_point_of_sales_detail('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Insert Transaction Detail
function insert_transaction_detail($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.insert_product_for_point_of_sales_detail('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Update Transaction Detail
function update_transaction_detail($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.set_new_point_of_sales_detail('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Remove Transaction Detail
function remove_transaction_detail($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT settings.remove_permanent_data('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Mengambil Summary Transaction
function get_summary_transaction_detail($input_function)
{
    $hasil = 0;
    $input = array("body" => array("point_of_sales_id" => $input_function));
    $result = get_transaction_detail($input);
    if (is_array($result) && count($result)) {
        foreach ($result as $baris) :
            $hasil = $hasil + $baris["grand_total"];
        endforeach;
    }
    return $hasil;
}

//Validate Point of Sales
function validate_data($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.validate_point_of_sales_completed('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row['result'], true);
    $hasil = $hasil['body'];
    return $hasil;
}

//Pay Transaction
function pay_transaction($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT pos.set_new_point_of_sales('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

// Get Data Customer
function get_data_customer($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT master.list_master_customer('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row["result"], true);
    $hasil = $hasil["body"];
    return $hasil;
}

//Insert Data Customer
function set_new_customer_data($input_function)
{
    include "../asset_default/koneksi.php";
    $input = json_encode($input_function);
    $query = "SELECT master.set_new_master_customer('" . $input . "') as result";
    $result = pg_query($link, $query);
    $row = pg_fetch_array($result);
    $hasil = json_decode($row['result'], true);
    $hasil = $hasil['body'];
    return $hasil;
}
