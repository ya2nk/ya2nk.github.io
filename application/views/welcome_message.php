<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CI-CRUD</title>
	<script src="<?= base_url(); ?>asset/js/jquery.min.js"></script>
	<script src="<?= base_url(); ?>asset/js/jquery.easyui.min.js"></script>
	<script src="<?= base_url(); ?>asset/js/notify.min.js"></script>
	
	<link href="<?= base_url(); ?>asset/css/icon.css" rel="stylesheet">
	<link href="<?= base_url(); ?>asset/css/default/easyui.css" rel="stylesheet">
	<script>
		var url,rows,id;
		$(function(){
			$('#dg').datagrid({
				title:'CI CRUD',
				url:'<?= site_url('welcome/data'); ?>',
				pagination:true,
				nowrap:false,
				rownumbers:true,
				toolbar:'#toolbar',
				singleSelect:true,
				onRowContextMenu:function(e,index,row){
					e.preventDefault();
					rows = row;
					id   = row.id;
					$(this).datagrid('selectRow',index);
					$('#mm').menu('show', {
						left:e.pageX,
						top:e.pageY
					});
				}
			});
			
			$.notify.defaults({
				globalPosition: 'bottom right',
				autoHideDelay: 4000,
				className: 'success'
			});
			
			$('#nama').textbox('textbox').keyup(function(){
				$('#dg').datagrid('load',{
					nama:this.value,
				});
			});
		});
		
		function tambah()
		{
			$('#dlg').dialog('open').dialog('setTitle','TAMBAH DATA');
			url = '<?= site_url('welcome/crud/simpan'); ?>';
		}
		
		function ubah()
		{
			$('#dlg').dialog('open').dialog('setTitle','UBAH DATA');
			$('#fm').form('load',rows);
			url = '<?= site_url('welcome/crud/ubah'); ?>';
		}
		
		function batal()
		{
			$('#fm').form('clear');
			$('#dlg').dialog('close');
		}
		
		function simpan()
		{
			$('#fm').form('submit',{
				url:url,
				queryParams:{
					id:id
				},
				success:function(result){
					if (result == 'success')
					{
						$('#dg').datagrid('reload');
						batal();
						$.notify('DATA BERHASIL DIPROSES');
					}
					else
					{
						$.notify('DATA GAGAL DIPROSES','error');
					}
				}
			});
		}
		
		function hapus()
		{
			$.messager.confirm('INFO','Apakah Yakin Akan Menghapus Data Ini?',function(r){
				if (r)
				{
					$.post('<?= site_url('welcome/crud/hapus'); ?>',{id:id},function(result){
						if (result == 'success')
						{
							$('#dg').datagrid('reload');
							$.notify('DATA BERHASIL DIHAPUS');
						}
						else
						{
							$.notify('DATA GAGAL DIHAPUS','error');
						}
					});
				}
			});
		}
	</script>
</head>
<body>
	<h1>CRUD MENGGUNAKAN CI</h1>
	<table id="dg" style="height:400px;width:900px">
		<thead>
			<tr>
				<th field="nama" sortable="true" halign="center" width="150">NAMA</th>
				<th field="alamat" sortable="true" halign="center" width="350">ALAMAT</th>
				<th field="no_telp" sortable="true" halign="center" width="150">NO TELP.</th>
				<th field="email" sortable="true" halign="center" width="150">EMAIL</th>
				<th field="jenis_kelamin" sortable="true" halign="center" width="100">JENIS KELAMIN</th>
				<th field="pesan" sortable="true" halign="center" width="450">PESAN</th>
			</tr>
		</thead>
	</table>
	<br>
	* Untuk Edit/Hapus Klik Kanan Pada Salah Satu Row.
	<div id="toolbar" style="padding:5px">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="tambah()">Tambah</a>
		<div style="margin-top:5px">
			<fieldset>
				<legend>Pencarian</legend>
				<table>
					<tr>
						<td>Nama</td>
						<td>: <input type="text" id="nama" class="easyui-textbox"></td>
					</tr>
				</table>
			</fieldset>
		</div>
	</div>
	<div id="dlg" class="easyui-dialog" closed="true" buttons="#dlg-buttons" style="padding:5px">
		<form id="fm" method="post">
			<table>
				<tr>
					<td>NAMA</td>
					<td>: <input type="text" name="nama" class="easyui-textbox" required="true"></td>
				</tr>
				<tr>
					<td>ALAMAT</td>
					<td>: <input type="text" name="alamat" class="easyui-textbox" data-options="multiline:true,height:80,width:250,required:true"></td>
				</tr>
				<tr>
					<td>NO TELP.</td>
					<td>: <input type="text" name="no_telp" class="easyui-textbox" required="true"></td>
				</tr>
				<tr>
					<td>EMAIL</td>
					<td>: <input type="text" name="email" class="easyui-textbox" required="true" data-options="validType:'email'"></td>
				</tr>
				<tr>
					<td>JENIS KELAMIN</td>
					<td>: <input type="radio" name="jenis_kelamin" value="L">Laki-Laki
						  <input type="radio" name="jenis_kelamin" value="P">Perempuan
					</td>
				</tr>
				<tr>
					<td>PESAN</td>
					<td>: <input type="text" name="pesan" class="easyui-textbox" data-options="multiline:true,height:80,width:250,required:true"></td>
				</tr>
			</table>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="simpan()">SIMPAN</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="batal()">BATAL</a>
	</div>
	
	<div id="mm" class="easyui-menu">
		<div iconCls="icon-edit" onclick="ubah()">Ubah Data</div>
		<div iconCls="icon-remove" onclick="hapus()">Hapus Data</div>
	</div>
</body>
</html>