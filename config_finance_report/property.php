<?php
include "api.php";
if (!empty($_POST)) {
    $output = '';
    if ($_POST['action_status'] == 'refresh_data_detail') {
        $output .= '
          <table id="structure_table" class="table table-striped table-bordered" style="width:100%">
             <thead>
             <tr>
                <th width="2%">Option</th>
                <th colspan = 4>Structure Finance Report</th>
             </tr>
          </thead>
          <tbody>';
        $input = array("body" => array("data_id" => $_POST['data_id']));
        $hasil = get_data_detail($input);
        if (is_array($hasil) && count($hasil)) {
            foreach ($hasil as $row) :
                //Config Button ditampilkan
                if ($row["structure_option"] == "add") {
                    $add_element = '<button type="button" name="view" id="' . $row["structure_id"] . '" class="btn btn-warning btn-xs add_account"><i class="fa fa-plus-circle"></i></button>';
                } else if ($row["structure_option"] == "remove") {
                    $add_element = '<button type="button" name="view" id="' . $row["structure_id"] . '" class="btn btn-danger btn-xs remove_account"><i class="fa fa-close"></i></button>';
                } else {
                    $add_element = '';
                }

                //Config Colsapan TD agar lebih menjorok
                if ($row["structure_level"] == "1") {
                    $colspan_element = '<td colspan = 4>' . $row["structure_name"] . '</td>';
                } else if ($row["structure_level"] == "2") {
                    $colspan_element = '<td></td><td colspan = 3>' . $row["structure_name"] . '</td>';
                } else if ($row["structure_level"] == "3") {
                    $colspan_element = '<td></td><td></td><td colspan = 2>' . $row["structure_name"] . '</td>';
                } else if ($row["structure_level"] == "4") {
                    $colspan_element = '<td></td><td></td><td></td><td>' . $row["structure_name"] . '</td>';
                }
                $output .= '
                <tr id="tr-' . $row["structure_id"] . '"> 
                   <td>' . $add_element . '</td>' . $colspan_element . '
                </tr>';
            endforeach;
        }
        $output .= '</tbody></table>';
    } elseif ($_POST['action_status'] == 'choose_finance_report_type_data') {
        $output .= '
      <table id="select_table" class="table table-striped table-bordered" style="width:100%">
         <thead>
         <tr>
            <th width="80%">Finance Report Type</th>
            <th width="20%">Option</th> 
         </tr>
      </thead>
      <tbody>
      ';
        // $input = ['body' => ['end_date' => $_POST['end_date'], 'finance_report_type_id' => $_POST['finance_report_type_id']]];
        $input = ['body' => ['id' => null]];
        $hasil = get_finance_report_type($input);
        if (is_array($hasil) && count($hasil)) {
            foreach ($hasil as $row) :
                $output .= '
            <tr>  
               <td>' . $row["structure_name"] . '</td>
               <td><button type="button" name="select" id="' . $row["id"] . '" class="btn btn-warning btn-xs select_finance_report_type_data">Select</button>                                  
               </td>
            </tr>
         ';
            endforeach;
        }
        $output .= '</tbody></table>';
    } elseif ($_POST['action_status'] == 'refresh_list_account') {
        $output .= '
    <input type="hidden" name="id" id="jq_structure_id" value="' . $_POST['structure_id']  . '" />
      <table id="select_table" class="table table-striped table-bordered" style="width:100%">
         <thead>
         <tr>
            <th width="40%">Account Code</th>
            <th width="40%">Account Name</th>
            <th width="20%">Option</th> 
         </tr>
      </thead>
      <tbody>
      ';
        $input = ['body' => ['finance_report_structure_id' => $_POST['structure_id']]];
        $hasil = get_account_data($input);
        if (is_array($hasil) && count($hasil)) {
            foreach ($hasil as $row) :
                $output .= '
            <tr>  
               <td>' . $row["account_code"] . '</td>
               <td>' . $row["account_name"] . '</td>
               <td><button type="button" name="select" id="' . $row["id"] . '" class="btn btn-warning btn-xs select_account">Select</button>                                  
               </td>
            </tr>
         ';
            endforeach;
        }
        $output .= '</tbody></table>';
    } elseif ($_POST['action_status'] == 'print_receipt') {
        $input = array("body" => array("id" => $_POST['transaction_id']));
        $hasil = get_data_detail($input);
        if (is_array($hasil) && count($hasil)) {
            foreach ($hasil as $row) :
                $trx_number = $row["transaction_number"];
                $trx_date = $row["transaction_date"];
                $customer = $row["customer_name"];
                $outlet = $row["outlet_name"];
                $grand_total = $row["grand_total"];
                $cash_total = $row["total_cash"];
                $change_total = $row["total_changes"];
            endforeach;
        }

        $output = '<html><head><title>POS Receipt</title>';
        $output .= '<style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }

        table {
            width: 300px;
            font-size: 15px;
            font-family: calibri;
            border-collapse: collapse;
        }

        .footer_header {
            width: 65%;
            text-align: right;
            font-family: calibri;
            font-size: 15px;
            color: black
        }

        .footer_content {
            width: 35%;
            text-align: right;
            vertical-align: center;
            font-family: calibri;
            font-size: 15px;
            color: black
        }

        .contet_numeric {
            text-align: right;
            vertical-align: center;
            font-family: calibri;
            font-size: 15px;
            color: black
        }

        .contet_text {
            vertical-align: center;
            font-family: calibri;
            font-size: 15px;
            color: black
        }
    </style>';
        $output .= '</head><body>';

        $output .= '<center>
        <table class="tb_header" border="0">
            <td align="center" vertical-align:top>
                <span style="color:black;"><b>' . $_POST['company_name'] . '</b></br>' . $_POST['company_addres'] . '</span></br>
                <span style="font-size:12pt">No .' . $trx_number . ', ' . format_date($trx_date) . '</span></br>
            </td>
        </table>
        <table id="tb_content" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center" width="40%" class="contet_text">Product</td>
                <td align="right" width="25%" class="contet_text">Qty</td>
                <td align="right" width="35%" class="contet_text">Total</td>
            </tr>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>';
        $input = ['body' => ['point_of_sales_id' => $_POST['transaction_id']]];
        $hasil = get_data_pos_detail($input);
        if (is_array($hasil) && count($hasil)) {
            foreach ($hasil as $baris) :
                $output .= '
          <tr>
            <td>' . $baris["product_name"] . '</td>
            <td class ="contet_numeric">' . format_decimal($baris["qty"]) . '</td>
            <td class ="contet_numeric">' . format_decimal($baris["grand_total"]) . '</td>
         </tr>';
            endforeach;
        }
        $output .= '
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
        </table>
        <table id="tb_foter" border="0">
            <tr>
                <td class="footer_header">Grand Total :</td>
                <td class="footer_content">' . format_decimal($grand_total) . '</td>
            </tr>
            <tr>
                <td class="footer_header">Cash :</td>
                <td class="footer_content">' . format_decimal($cash_total) . '</td>
            </tr>
            <tr>
                <td class="footer_header">Change :</td>
                <td class="footer_content">' . format_decimal($change_total) . '</td>
            </tr></br>
            <td colspan="2" align="center">****** THANK YOU ******</br></td>
            </tr>
        </table>\
    </center>
   
   ';

        $output .= '</body></html>';
    }
    echo $output;
}
