  <!-- .modal -->


  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script type="text/javascript">
      $(document).ready(function() {

          //jika n_input karakter lebih dari 3 maka cari pegawai
          $('#n_input').keyup(function() {
              var query_name = $('#n_input').val();

              if (query_name.length > 3) {
                  //console.log(query_name.length);
                  //ambil data dari url http://localhost:8000/search_user_byname/query_name untuk dimasukan ke autocomplete
                  $("#n_input").autocomplete({
                      source: function(request, response) {
                          $.ajax({
                              url: "http://localhost:8000/search_user_byname/" +
                                  query_name,
                              dataType: "json",
                              success: function(data) {
                                  // console.log(data);
                                  response($.map(data, function(item) {
                                      return {
                                          //label nip_lama+name
                                          label: item.nip_lama + "-" +
                                              item.name,
                                          value: item.id
                                      }
                                  }));
                              },
                              error: function(response) {
                                  console.log("response error");

                              }
                          });
                      }
                  });

                  //jika n_input kosong maka disable button add_pegawai
              } else {
                  $('#add_pegawai').prop('disabled', true);
              }


          });

          //jika n_input autocomplete selected simpan variabel nya dan aktifkan tombol n_add_pegawai
          $("#n_input").autocomplete({
              select: function(event, ui) {
                  event.preventDefault();
                  $("#n_input").val(ui.item.label);
                  var item = ui.item;
                  //console.log(item);
                  //pisahkan label menjadi 2 bagian dengan pemisah - dan simpan ke variabel nip_lama dan name
                  var nip_lama = item.label.split("-")[0];
                  var name = item.label.split("-")[1];
                  //ambil email dari /search_user_by_niplama/nip_lama 
                  $.ajax({
                      url: "http://localhost:8000/search_user_by_niplama/" +
                          nip_lama,
                      dataType: "text",
                      success: function(data) {
                          console.log(data);
                          var email = data;
                          n_tr_str =
                              "<tr><td class='id'></td>" +
                              "<td>" + nip_lama +
                              "<input hidden name='ca_nip[]' value ='" +
                              nip_lama +
                              "'>" +
                              "</td>" +
                              "<td>" + name +
                              "<input hidden name='ca_name[]' value = '" +
                              name + "'  >" +
                              "</td>" +
                              "<td>" + email +
                              "<input hidden name='ca_email[]' value = '" +
                              email + "'  >" +
                              "</td>" +
                              "<td> Change Agents <input hidden name = 'change_agents[]' value = '" +
                              item.value + "'> </td>" +
                              "<td>" +
                              "<button type='button' name='remove' id='" +
                              item.value +
                              "' class='btn btn-danger btn_remove'>delete</button>" +
                              "</td>" +
                              "</tr>";

                      },
                      error: function(response) {
                          console.log("response error");

                      }
                  });






                  $('#n_add_pegawai').prop('disabled', false);
              }
          });




          $('#n_add_pegawai').click(function() {
              //tambahkan pegawai di n_input ke table example1
              //ambil data dari autocomplete n_input yang dipilih
              var item = $("#n_input").autocomplete("instance").currentItem;
              //buat row baru di table example1

              $('#example1 tbody').append(n_tr_str);
              console.log(n_tr_str);
              $('#n_input').val('');
              
              $('#n_input').focus();
              updateRowOrder();
              $(this).prop('disabled', true);
          });



      });
  </script>

  <div class="modal fade" id="modal-default-name">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Cari Pegawai</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body ui-front">

                  <div class="form-group">
                      <label>Masukan nama pegawai</label>
                      {{-- input autocomplete jquery nama pegawai --}}
                      <input type="text" class="form-control" id="n_input" placeholder="Masukan nama pegawai">


                  </div>


                  <button type="button" class="btn btn-primary" id="n_add_pegawai" disabled>Tambah Pegawai</button>


              </div>

          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

  <!-- /.modal -->
