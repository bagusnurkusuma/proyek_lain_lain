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
                <h2>Register User</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><button type="button" name="refresh_user" id="jq_refresh_user" class="btn btn-success refresh_data_user"><i class="fa fa-refresh"></i></button></li>
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card-box table-responsive" id="data_detail">
                      <!-- Import From Form File -->
                    </div>
                  </div>
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

<!-- Popup Change Password-->
<div id="changepassModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="card-box table-responsive" id="form_change">
          <!-- Import From Form File -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Pop up Hak Akses -->
<div id="hakModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Hak Akses</h4>
        <div align="right">
          <button type="button" name="add_user_role" id="jq_add_user_role" class="btn btn-success add_user_role"><i class="fa fa-plus-circle"></i></button>
          <button type="button" name="refresh_user_role" id="jq_refresh_user_role" class="btn btn-success refresh_data_user_role"><i class="fa fa-refresh"></i></button>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-box table-responsive" id="form_hak">
          <!-- Import From Form File -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Pop up Add Akses -->
<div id="addmenuprocessModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Menu Process</h4>
        <div align="right">
          <button type="button" name="refresh_menu_proses" id="jq_refresh_menu_proses" class="btn btn-success refresh_data_menu_proses"><i class="fa fa-refresh"></i></button>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-box table-responsive" id="form_menu_process">
          <!-- Import From Form File -->
        </div>
        <div class="modal-footer">
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function act_refresh_table_register() {
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        action_status: "refresh_data_detail"
      },
      success: function(data) {
        $("#data_detail").html(data);
        $("#datatable").DataTable()
      }
    });
  }

  function act_refresh_table_hak_akes(arg_data_id) {
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        action_status: "change_role_user",
        data_id: arg_data_id
      },
      success: function(data) {
        $("#form_hak").html(data);
        $("#change_role_user_table").DataTable();
      }
    });
  }

  function act_refresh_table_menu_access() {
    $.ajax({
      url: "property.php",
      method: "POST",
      data: {
        action_status: "add_user_role",
        data_id: $("#jq_user_role_id").val()
      },
      success: function(data) {
        $("#form_menu_process").html(data);
        $("#add_user_role_table").DataTable();
      }
    });
  }

  //FormLoad langsung Refresh Table User
  $(document).ready(function() {
    act_refresh_table_register();
  })

  $(document).ready(function() {
    //Refresh Table User
    $(document).on("click", ".refresh_data_user", function() {
      act_refresh_table_register();
    })

    //Change Password Data
    $(document).on("click", ".change_password_user", function() {
      var data_id = $(this).attr("id");
      var action_status = "change_password_user";
      var user = $("#jq_pengguna").val();
      $.ajax({
        url: "property.php",
        method: "POST",
        data: {
          data_id: data_id,
          action_status: action_status,
          user: user
        },
        success: function(data) {
          $("#form_change").html(data);
          $("#changepassModal").modal("show");
        }
      });
    });

    // Change Active User
    $(document).on("click", ".change_active_user", function() {
      var data_id = $(this).attr("id");
      var text = "Are you sure change active status this User ?";
      if (confirm(text) == true) {
        $(document).ready(function() {
          $.ajax({
            url: "action.php",
            method: "POST",
            data: {
              action_status: "change_active_status",
              data_id: data_id
            },
            success: function(data) {
              act_refresh_table_register();
            }
          });

        });
      } else {}
    });

    //Change Role User
    $(document).on("click", ".change_role_user", function() {
      var user_role_id = $(this).attr("id");
      act_refresh_table_hak_akes(user_role_id);
      $("#hakModal").modal("show");
    });

    //Refresh Table User Acess
    $(document).on("click", ".refresh_data_user_role", function() {
      var user_role_id = $("#jq_user_role_id").val();
      act_refresh_table_hak_akes(user_role_id);
    })

    //Valdate dan Change Password Data
    $(document).on("click", ".change_password_data", function() {
      if ($("#jq_new_password").val() == "") {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "Please fill a new password !",
          icon: "warning"
        });
      } else if ($("#jq_re_enter_password").val() == "") {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "Please fill a new password confirmation !",
          icon: "warning"
        });
      } else if ($("#jq_new_password").val() !== $("#jq_re_enter_password").val()) {
        Swal.fire({
          position: "top",
          title: "Warning",
          text: "The password and confirmation password are not the same, please check again !",
          icon: "warning"
        });
      } else {
        $.ajax({
          url: "action.php",
          method: "POST",
          data: $("#change_form").serialize(),
          success: function(data) {
            $("#change_form")[0].reset();
            $("#changepassModal").modal("hide");
            act_refresh_table_register();
          }
        });
      }
    });

    //Add Menu Process
    $(document).on("click", ".add_user_role", function() {
      act_refresh_table_menu_access();
      $("#addmenuprocessModal").modal("show");
    });

    //Remove User Role
    $(document).on("click", ".remove_hak_data", function() {
      var user_role_id = $("#jq_user_role_id").val();
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          action_status: "remove_hak_detail",
          data_id: $(this).attr("id")
        },
        success: function(data) {
          act_refresh_table_hak_akes(user_role_id);
        }
      });
    });

    //Refresh Table Menu Process
    $(document).on("click", ".refresh_data_menu_proses", function() {
      act_refresh_table_menu_access();
    })

    //Select Menu Process
    $(document).on("click", ".select_menu_process", function() {
      var user_role_id = $("#jq_user_role_id").val();
      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          action_status: "select_menu_process",
          menu_proces_id: $(this).attr("id"),
          user_role_id: user_role_id,
          created_by: $("#jq_pengguna").val()
        },
        success: function(data) {
          act_refresh_table_menu_access();
          act_refresh_table_hak_akes(user_role_id);
        }
      });
    });
  });
</script>
