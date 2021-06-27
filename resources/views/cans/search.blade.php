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
                      <input class="form-control" type='text' id='p_input' name='search' placeholder='Enter nip lama'>
                  </div>

                  <input type='button' value='Search' id='sp_button'> <br><br>

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
                  <button type="button" class="btn btn-primary" id="add_pegawai">Tambah Pegawai</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

  <!-- /.modal -->


  <script type="text/javascript">
      $(document).ready(function() {
          $('#p_input').keypress(function(e) {
              var key = e.which;
              if (key == 13) // the enter key code
              {
                  $('#sp_button').click();
                  return false;
              }
          });
      });
      $(document).ready(function() {
          var year = new Date().getFullYear();
          $("#year").append('<option value=' + year + '>' + year + '</option>');
      });
      $(document).ready(function() {
          $('#sp_button').click(function() {
              var id = Number($('#p_input').val().trim());
              if (id > 0) {
                  cariPegawai(id);
              }
          });

      });

      $(document).on('click', '.btn_remove', function() {
          var button_id = $(this).attr("id");
          $('#row' + button_id + '').remove();
      });
      var tr_str;

      function cariPegawai(id) {
          var urlx = '{{ route('get_user_byniplama', ':id') }}';
          urlx = urlx.replace(':id', id);
          $.ajax({
              url: urlx,
              type: 'get',
              dataType: 'json',
              success: function(response) {
                  var len = 0;
                  $('#userTable tbody').empty(); // Empty <tbody>
                  if (response['data'] != null) {
                      var id = response['data'].id;
                      var name = response['data'].name;
                      var email = response['data'].email;
                      var nip_lama = response['data'].nip_lama;
                      //alert(name);
                      tr_str = "<tr id='row" + id +
                          "' ><td >(✓)<input hidden name = 'change_agents[]' value = '" +
                          id + "'></td>" +
                          "<td>" + nip_lama + "<input hidden name='ca_nip[]' value ='" + nip_lama + "'>" +
                          "</td>" +
                          "<td>" + name + "<input hidden name='ca_name[]' value = '" + name + "'  >" +
                          "</td>" +
                          "<td>" + email + "<input hidden name='ca_email[]' value = '" + email + "'  >" +
                          "</td>" +
                          "<td> Change Agents </td>" +
                          "<td>" + "<button type='button' name='remove' id='" + id +
                          "' class='btn btn-danger btn_remove'>delete</button>" + "</td>" +
                          "</tr>";
                      var tr_str2 = "<tr>" +
                          "<td>" + nip_lama + "</td>" +
                          "<td>" + name + "</td>" +
                          "<td>" + email + "</td>" +
                          "</tr>";
                      $("#userTable tbody").append(tr_str2);
                  }
              }
          });
      }
      $(document).ready(function() {
          $('#add_pegawai').click(function() {
              $('#userTable tbody').empty();
              $('#example1 tbody').prepend(tr_str);
              $('#p_input').val('');
              $('#p_input').focus();
          });
      });
  </script>
