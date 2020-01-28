<!DOCTYPE html>
<html>
<head>
	<title>Belajar CRUD</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.dataTables.min.css">
</head>
<body>
	<div class="container">
		<h2>Belajar CRUD</h2>
		<h3>Data Siswa</h3>
		<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_tambah">Tambah Siswa</button>
		<br><br>
		<table id="myTable" class="table table-striped table-bordered" style="width:100%">
		    <thead class="thead-dark">
		        <tr>
		            <th>No</th>
		            <th>Nama</th>
		            <th>Jenis Kelamin</th>
		            <th>Alamat</th>
		            <th>Opsi</th>
		        </tr>
		    </thead>
		    <tbody id="data_siswa">
		    
		    </tbody>
		</table>
	</div>

	<!-- Modal -->
	<form action="#" id="form_tambah">
	<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	        <div class="form-group">
			    <label for="exampleInputEmail1">Nama</label>
			    <input type="text" class="form-control" name="nama">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Jenis Kelamin</label>
			    <select class="form-control" name="jenis_kelamin">
			    	<option value="Laki-Laki">Laki - Laki</option>
			    	<option value="Perempuan">Perempuan</option>
			    </select>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Alamat</label>
			    <input type="text" class="form-control" name="alamat">
			  </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
	        <button type="submit" class="btn btn-primary" id="btn_simpan">Simpan</button>
	      </div>
	    </div>
	  </div>
	</div>
	</form>

	<!-- Modal -->
	<form action="#" id="form_edit">
	<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	      	<input type="hidden" name="id_siswa">
	        <div class="form-group">
			    <label for="exampleInputEmail1">Nama</label>
			    <input type="text" class="form-control" name="nama">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Jenis Kelamin</label>
			    <select class="form-control" name="jenis_kelamin">
			    	<option value="Laki-Laki">Laki - Laki</option>
			    	<option value="Perempuan">Perempuan</option>
			    </select>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Alamat</label>
			    <input type="text" class="form-control" name="alamat">
			  </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
	        <button type="submit" class="btn btn-primary" id="btn_update">Simpan</button>
	      </div>
	    </div>
	  </div>
	</div>
	</form>

</body>
</html>


<script src="<?php echo base_url()?>assets/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>

<script>
      $(document).ready( function () {
        
        tampil_data();

        $('#myTable').DataTable();

        function tampil_data(){
            $.ajax({
                type  : 'GET',
                url   : '<?php echo base_url()?>index.php/siswa/data_siswa',
                async : false,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    var no = 0;
                    for(i=0; i<data.length; i++){
                        no++;
                        html += '<tr>'+
                                    '<td>'+no+'</td>'+
                                    '<td>'+data[i].nama+'</td>'+
                                    '<td>'+data[i].jenis_kelamin+'</td>'+
                                    '<td>'+data[i].alamat+'</td>'+
                                    '<td>'+
                                      '<a href="<?php echo base_url()?>admin/siswa/detail_siswa/'+data[i].id_siswa+'" title="Lihat"><button class="btn btn-success btn-sm">Lihat</button></a>'+' '+
                                      '<button class="btn btn-primary btn-sm item_edit" data="'+data[i].id_siswa+'" title="Edit">Edit</button>'+' '+
                                      '<button class="btn btn-danger btn-sm item_hapus" data="'+data[i].id_siswa+'" title="Hapus">Hapus</button>'+
                                    '</td>'+
                                '</tr>';
                    }

                    $('#data_siswa').html(html);
                }

            });

        }

        // reset FORM TAMBAH
        $(document).on('click', '#btn_simpan', function(event) {
          event.preventDefault();
          $('#form_tambah')[0].reset(); // reset form on modals
        });

        //Simpan Siswa
        $('#btn_simpan').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('index.php/siswa/simpan')?>",
                dataType : "JSON",
                data: $('#form_tambah').serialize(),
                success: function(data){
                    
                    if(data.status === true){
                         $('#modal_tambah').modal('hide');

                        tampil_data();
                    }else{
                        alert('Gagal Disimpan');

                        tampil_data();
                    }
                }
            });
            return false;
        });

        //Edit
        $('#data_siswa').on('click','.item_edit',function(){
            var id=$(this).attr('data');
            $.ajax({
                type : "GET",
                url  : "<?php echo base_url()?>index.php/siswa/edit/" + id,
                dataType : "JSON",
                success: function(data){
                  $('#modal_edit').modal('show');
                  $('[name="id_siswa"]').val(data.id_siswa);
                  $('[name="nama"]').val(data.nama);
                  $('[name="jenis_kelamin"]').val(data.jenis_kelamin);
                  $('[name="alamat"]').val(data.alamat);
                }
            });
            return false;
        });

        //Update Siswa
        $('#btn_update').on('click',function(){
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('index.php/siswa/update')?>" ,
                dataType : "JSON",
                data : $('#form_edit').serialize(),
                success: function(data){
                    if(data.status === true){ 
                        $('#modal_edit').modal('hide');
                        tampil_data();
                    }else {
                        alert('Gagal Diedit');
                        tampil_data();
                    };
                }
            });
            return false;
        });

        //Hapus Siswa
        $('#data_siswa').on('click','.item_hapus',function(){
          if (confirm('Apa anda yakin ingin menghapus data ini')) {
            var id=$(this).attr('data');
            $.ajax({
              type : "POST",
              url  : "<?php echo base_url('index.php/siswa/hapus')?>/" + id,
              dataType : "JSON",
              success: function(data){
              	if(data.status === true){ 
                    tampil_data();
                }else {
                    alert('Gagal Diedit');
            		tampil_data();
                };
              }
            });
            return false;          
          }
        });

      } );    
    </script>
