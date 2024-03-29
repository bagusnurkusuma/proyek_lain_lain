<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<?php
include "../asset_default/side_bar.php";
include "api.php";
?>

<body class="nav-md">
  <input type="hidden" name="penguna" id="jq_pengguna" value=<?php echo $pengguna; ?> readonly="true">
  <div class="container body">
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="content">
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
              <div class="x_title">
                <h2>Master Outlet</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div align="right">
                  <button type="button" name="show_archive" id="jq_show_archive" class="btn btn-primary show_archive"><i class="fa fa-inbox"></i></button>
                  <button type="button" name="add_data" id="jq_add_data" class="btn btn-warning add_data"><i class="fa fa-plus-circle"></i></button>
                  <button type="button" name="refresh" id="jq_refresh" class="btn btn-success refresh_data"><i class="fa fa-refresh"></i></button>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="card-box table-responsive" id="data_detail">
                  <!-- Import From Form File -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->
    </div>
  </div>

</html>

<!-- Popup Archive-->
<div id="archiveModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Archive Data</h4>
        <div>
          <button type="button" name="refresh_unarchive" id="jq_refresh_unarchive" class="btn btn-success refresh_unarchive_data"><i class="fa fa-refresh"></i></button>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-box table-responsive" id="form_archive">
          <!-- Import From Form File -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Pop up Data Detail -->
<div id="editModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Data Detail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="card-box table-responsive" id="form_edit">
          <!-- Import From Form File -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

<!-- Pop up Selected -->
<div id="selectModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Select Data</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="card-box table-responsive" id="form_select">
          <!-- Import From Form File -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function act_refresh_data_detail() {
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        action_status: "refresh_data_detail"
      },
      success: function(data) {
        $("#data_detail").html(data);
        $("table#master_table").pretty_format_table();
        $('table#master_table').DataTable();
      }
    });
  }

  function act_refresh_data_archive() {
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        action_status: "show_archive_data"
      },
      success: function(data) {
        $("#form_archive").html(data);
        $("table#archive_table").pretty_format_table();
        $('table#archive_table').DataTable();
      }
    });
  }

  function get_data_detail_edit(arg_data_id, arg_action_status) {
    var created_by = $("#jq_pengguna").val();
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        data_id: arg_data_id,
        action_status: arg_action_status,
        created_by: created_by
      },
      success: function(data) {
        $('#form_edit').html(data);
        $('#editModal').modal('show');
      }
    });
  }

  function act_refresh_data_warehouse() {
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        action_status: 'choose_warehouse_data'
      },
      success: function(data) {
        $('#form_select').html(data);
        $("table#select_table").pretty_format_table();
        $('table#select_table').DataTable();
      }
    });
  }

  //FormLoad langsung Refresh Table 
  $(document).ready(function() {
    act_refresh_data_detail();
  })

  $(document).ready(function() {

    //Refresh Table
    $(document).on('click', '.refresh', function() {
      act_refresh_data_detail();
    })

    //Add Data
    $(document).on('click', '.add_data', function() {
      get_data_detail_edit(null, "insert_detail");
    });

    //Detail Data
    $(document).on('click', '.view_data', function() {
      var data_id = $(this).attr("id");
      get_data_detail_edit(data_id, "view_detail");
    });

    //Edit Data
    $(document).on('click', '.edit_data', function() {
      var data_id = $(this).attr("id");
      get_data_detail_edit(data_id, "edit_detail");
    });

    //Show Popup Archive Data
    $(document).on('click', '.archive_data', function() {
      var data_id = $(this).attr("id");
      var action_status = 'archive_detail';
      var created_by = $("#jq_pengguna").val();
      $.ajax({
        url: "property.php",
        method: "POST",
        data: {
          data_id: data_id,
          action_status: action_status,
          created_by: created_by
        },
        success: function(data) {
          $('#form_archive').html(data);
          $('#archiveModal').modal('show');
        }
      });
    });


    //Archive Detail
    $(document).on('click', '.archive_detail', function() {
      if ($('#jq_archive_reason').val() == '') {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "Archive Reason Must be Filled !",
          icon: "warning"
        });
      } else {
        $.ajax({
          url: "action.php",
          method: "POST",
          data: $('#archive_form').serialize(),
          beforeSend: function() {
            $('#archive').val("Archiving");
          },
          success: function(data) {
            $('#archive_form')[0].reset();
            $('#archiveModal').modal('hide');
            act_refresh_data_detail();
          }
        });
      }
    });

    //Show Archive Data
    $(document).on('click', '.show_archive', function() {
      act_refresh_data_archive();
      $('#archiveModal').modal('show');
    });

    //Unarchive Data
    $(document).on('click', '.unarchive_data', function() {
      var data_id = $(this).attr("id");
      var action_status = 'unarchive_detail';
      var created_by = $("#jq_pengguna").val();
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          data_id: data_id,
          action_status: action_status,
          created_by: created_by
        },
        success: function(data) {
          act_refresh_data_archive();
          act_refresh_data_detail();
        }
      });
    });

    //Refresh Unarchive
    $(document).on('click', '.refresh_unarchive_data', function() {
      act_refresh_data_archive();
      act_refresh_data_detail();
    });

    //Update Detail
    $(document).on('click', '.update_detail', function() {
      if ($('#jq_outlet_code').val() == '') {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "Outlet Code Must be Filled !",
          icon: "warning"
        });
      } else if ($('#jq_outlet_name').val() == "") {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "Outlet Name Must be Filled !",
          icon: "warning"
        });
      } else if ($('#jq_warehouse_id').val() == '') {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "Warehouse Must be Selected !",
          icon: "warning"
        });
      } else {
        $.ajax({
          url: "action.php",
          method: "POST",
          data: {
            action_status: "validate_detail",
            id: $('#jq_id').val(),
            code: $('#jq_outlet_code').val(),
            name: $('#jq_outlet_name').val()
          },
          success: function(data) {
            var parsedData = $.parseJSON(data);
            var result = parsedData[0].msg;
            if (result == "") {
              $.ajax({
                url: "action.php",
                method: "POST",
                data: $('#update_form').serialize(),
                beforeSend: function() {
                  $('#update').val("Updating");
                },
                success: function(data) {
                  $('#update_form')[0].reset();
                  $('#editModal').modal('hide');
                  act_refresh_data_detail();
                }
              });
            } else {
              Swal.fire({
                position: "top",
                title: "Warning",
                text: result,
                icon: "warning"
              });
            }
          }
        });
      }
    });

    //Choose Warehouse Data
    $(document).on('click', '.choose_warehouse_data', function() {
      act_refresh_data_warehouse();
      $('#selectModal').modal('show');
    });

    //Select Warehouse Data
    $(document).on('click', '.select_warehouse_data', function() {
      var data_id = $(this).attr("id");
      var action_status = 'select_warehouse_data';
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          data_id: data_id,
          action_status: action_status
        },
        success: function(data) {
          var parsedData = $.parseJSON(data);
          $("#jq_warehouse_id").val(parsedData[0].id);
          $("#jq_warehouse_name").val(parsedData[0].warehouse_name);
          $('#selectModal').modal('hide');
        }
      });
    });

  });
</script>
