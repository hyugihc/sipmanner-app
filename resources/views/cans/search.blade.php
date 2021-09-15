  <!-- .modal -->
  <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Cari Pegawai</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <label>Masukan 5 digit NIP lama</label>
                      <input class="form-control" type='number' id='p_input' name='search' placeholder='Enter nip lama'>
                  </div>

                  <button class="btn btn-primary" type='button' value='Search' id='sp_button'>
                      Search

                  </button><br><br>


                  <table class="table table-bordered" id='userTable'>
                      <thead>
                          <tr>
                              <th>Nip Lama</th>
                              <th>Name</th>
                              <th>Email</th>
                          </tr>
                      </thead>
                      <tbody id="user_table"></tbody>
                  </table>
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="add_pegawai" disabled>Tambah Pegawai</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

  <!-- /.modal -->


  <script type="text/javascript">
      /* function for dynamic numbering */
      function updateRowOrder() {
          $('td.id').each(function(i) {
              $(this).text(i + 1);
          });
      }
      $(document).ready(function() {
          $('#p_input').keypress(function(e) {
              var key = e.which;
              if (key == 13)
              // the enter key code
              {
                  $('#sp_button').click();
                  return false;
              }
          });
      });
      $(document).ready(function() {
          updateRowOrder();
      });
      $(document).ready(function() {
          $('#sp_button').click(function() {
              var id = Number($('#p_input').val().trim());
              if (id > 0) {
                  var loadingText =
                      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Loading...";
                  $("#sp_button").html(loadingText);
                  cariPegawai(id);
              }
          });

      });

      $(document).on('click', '.btn_remove', function() {
          //   var button_id = $(this).attr("id");
          //   $('#row' + button_id + '').remove();
          //   updateRowOrder();
          /* Just remove the tr on the click of a mouse */
          $(this).closest("tr").remove();
          /* Update Numbering */
          updateRowOrder();
      });
      var tr_str;

      function cariPegawai(id) {
          var urlx = '{{ route('get_user_byniplama_sso', ':id') }}';
          urlx = urlx.replace(':id', id);
          $.ajax({
              url: urlx,
              type: 'get',
              dataType: 'json',
              success: function(response) {
                  // console.log("response succes");
                  var len = 0;
                  $('#userTable tbody').empty(); // Empty <tbody>
                  if (response['data'] != null) {
                      var id = response['data'].id;
                      var name = response['data'].name;
                      var email = response['data'].email;
                      var nip_lama = response['data'].nip_lama;
                      tr_str = "<tr><td class='id'></td>" +
                          "<td>" + nip_lama + "<input hidden name='ca_nip[]' value ='" + nip_lama + "'>" +
                          "</td>" +
                          "<td>" + name + "<input hidden name='ca_name[]' value = '" + name + "'  >" +
                          "</td>" +
                          "<td>" + email + "<input hidden name='ca_email[]' value = '" + email + "'  >" +
                          "</td>" +
                          "<td> Change Agents <input hidden name = 'change_agents[]' value = '" +
                          id + "'> </td>" +
                          "<td>" + "<button type='button' name='remove' id='" + id +
                          "' class='btn btn-danger btn_remove'>delete</button>" + "</td>" +
                          "</tr>";
                      var tr_str2 = "<tr>" +
                          "<td>" + nip_lama + "</td>" +
                          "<td>" + name + "</td>" +
                          "<td>" + email + "</td>" +
                          "</tr>";
                      $("#userTable tbody").append(tr_str2);
                      $("#sp_button").html("Search");
                      $('#add_pegawai').prop('disabled', false);
                      $('#add_pegawai').focus();
                  }
              },
              error: function(response) {
                  console.log("response error");
                  try {
                      data = JSON.parse(response);
                  } catch (e) {
                      $('#userTable tbody').empty();
                      var tr_str2 = "<tr>" +
                          "<td>Pegawai tidak ditemukan </td>" +
                          "</tr>";
                      $("#userTable tbody").append(tr_str2);
                      $("#sp_button").html("Search");
                  }
              }
          });
      }
      $(document).ready(function() {
          $('#add_pegawai').click(function() {
              $('#userTable tbody').empty();
              $('#example1 tbody').append(tr_str);
              var tr_str4 = "<tr>" +
                  "<td>pegawai ditambahkan </td>" +
                  "</tr>";
              $("#userTable tbody").append(tr_str4);
              $('#p_input').val('');
              $('#p_input').focus();
              updateRowOrder();
              $(this).prop('disabled', true);
          });


      });
  </script>
