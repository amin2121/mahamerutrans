<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets_landing_absensi/style.css">
	<script src="<?= base_url() ?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
</head>
<style media="screen">
	.profile__content{
		display: none;
	}
</style>
<!-- <body style="background: #00c6ff;background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);background: linear-gradient(to right, #0072ff, #00c6ff);"> -->
<body style="background-image: url('<?php echo $background ?>'); background-repeat: no-repeat; background-size: cover; position: relative; min-height: 100vh;">
	<div class="profile__container" style="z-index: 5; position: relative;">

		<div class="profile__header">
			<h1 class="profile__title" style="color: white; font-size: 30px;">Absensi Siswa <br> <span style="">SMK Muhammadiyah Lumajang</span></h1>
			<input type="text" class="profile__input-absen" id="input-absen" placeholder="Masukkan No Siswa" onkeyup="setTimeout(get_data_absen(event), 5000)">
			<input type="hidden" id="id-aturan-jam-siswa" value="<?php echo $aturan_jam['id_aturan_jam_siswa']; ?>">
			<input type="hidden" id="nama-aturan-jam-siswa" value="<?php echo $aturan_jam['nama']; ?>">
			<input type="hidden" id="jam-masuk" value="<?php echo $aturan_jam['jam_masuk']; ?>">
			<input type="hidden" id="jam-pulang" value="<?php echo $aturan_jam['jam_pulang']; ?>">
		</div>

		<div class="profile__loading" style="text-align: center; margin-top: 5rem; display: none;">
			<img src="<?= base_url('assets/loading-table.gif') ?>" alt="<?= base_url('assets/loading-table.gif') ?>" width="70">
		</div>

		<div class="profile__alert-warning profile__content" style="display: none; width: 100%;">
			<div class="profile__detail">
				<div class="profile__detail-header">
					<h2>Peringatan</h2>
				</div>
				<div class="" style="padding: 20px 40px; text-align: center; display: flex; justify-content: center; align-items: center; flex-direction: column; height: 400px;">
					<img src="<?php echo base_url(); ?>assets_landing_absensi/images/error.png" alt="ok" style="width: 100px; height: 100px;">
					<h1 style="margin-top: 4px; margin-bottom: 20px; font-size: 28px;">Warning</h1>
					<p style="font-size: 18px;">Anda Sudah Absen</p>
				</div>
			</div>
		</div>

		<div class="profile__alert-error profile__content" style="display: none; width: 100%;">
			<div class="profile__detail">
				<div class="profile__detail-header">
					<h2>Error</h2>
				</div>
				<div class="" style="padding: 20px 40px; text-align: center; display: flex; justify-content: center; align-items: center; flex-direction: column; height: 400px;">
					<img src="<?php echo base_url(); ?>assets_landing_absensi/images/err.png" alt="ok" style="width: 100px; height: 100px;">
					<h1 style="margin-top: 4px; margin-bottom: 20px; font-size: 28px;">Error</h1>
					<p style="font-size: 18px;">Coba Absen Kembali</p>
				</div>
			</div>
		</div>

		<div class="profile__content content__information">
			<div class="profile__detail">
				<div class="profile__detail-header">
					<h2>Informasi Siswa</h2>
				</div>
				<div style="display: flex; justify-content: space-between; padding: 20px 40px; margin-bottom: 1rem;">
					<div class="profile__time-date">
						<div class="profile__date" style="font-size: 20px; margin-bottom: 8px;">
							<span style="min-width: 90px; display: inline-block;">Tanggal</span>
							<span style="font-weight: bold;" id="text-tanggal"></span>
						</div>
					</div>
					<div>
						<div class="profile__time" style="font-size: 40px;">
							<span style="font-weight: bold;" id="text-jam"></span>
						</div>
					</div>
					<div>
						<span style="display: block; font-weight: bold; text-align: right; font-size: 14px; margin-bottom: .5rem;">Status : </span>
						<span style="display: block; text-align: right;  font-size: 24px; font-weight: bold;" id="text-status"></span>
					</div>
				</div>
				<span style="display: block; height: 1px; border: 1px solid rgb(226 232 240);"></span>
				<div class="" style="padding: 20px 40px; display: flex; justify-content: space-between; margin-top: 2rem;">
					<div>
						<div class="profile__item">
							<span style="font-size: 18px;">Nama Siswa :</span>
							<span style="font-size: 18px; font-weight: bold;" id="text-nama-siswa"></span>
						</div>
						<div class="profile__item">
							<span style="font-size: 18px;">Kelas :</span>
							<span style="font-size: 18px; font-weight: bold;" id="text-kelas"></span>
						</div>
						<div class="profile__item">
							<span style="font-size: 18px;">Jenis Kelamin :</span>
							<span style="font-size: 18px; font-weight: bold;" id="text-jenis-kelamin"></span>
						</div>
						<div class="profile__item">
							<span style="font-size: 18px;">NISN :</span>
							<span style="font-size: 18px; font-weight: bold;" id="text-nisn"></span>
						</div>
					</div>
					<div style="text-align: right;">
						<img id="image-siswa" alt="man" style="width: 340px; height: 340px; object-fit: contain; border-radius: 5px; margin-top: 5px; margin-left: auto;">
					</div>
				</div>
			</div>
		</div>

	</div>
	<script>
	    $(document).ready(function() {
	      $(`#input-absen`).focus()
	    })

		$(document).on('click', function() {
			$(`#input-absen`).focus()
		})

	    function get_data_absen(e) {

			if(e.keyCode === 13){
				$(`.profile__loading`).show()
				
				let input_absen = $(`#input-absen`).val()
				$(`#input-absen`).attr('readonly', true)

				let id_aturan_jam_siswa = $(`#id-aturan-jam-siswa`).val()
				let nama_aturan_jam_siswa = $(`#nama-aturan-jam-siswa`).val()
				let jam_masuk = $(`#jam-masuk`).val()
				let jam_pulang = $(`#jam-pulang`).val()
				$.ajax({
					url: '<?= base_url('landing/absen_siswa/get_data_absen') ?>',
					method: 'GET',
					data: {input_absen, id_aturan_jam_siswa, nama_aturan_jam_siswa, jam_masuk, jam_pulang},
					dataType: 'json',
					async : false,
					success: function (row) {
						if (row.result == 'true') {
							let css_status_telat = ''
							let status_wa = ''
							if (row.data.status == 'Tidak Tepat Waktu') {
								css_status_telat = 'telat'
								status_wa = 'masuk'
								$('.profile__detail-header').css('background-color', 'rgb(56 189 248)')
							} else if (row.data.status == 'Tepat Waktu') {
								css_status_telat = 'tidak-telat'
								status_wa = 'masuk'
								$('.profile__detail-header').css('background-color', 'rgb(56 189 248)')
							} else if (row.data.status == 'Pulang') {
								css_status_telat = 'pulang'
								status_wa = 'pulang'
								$('.profile__detail-header').css('background-color', 'rgb(250 204 21)')
							}

							$('#text-tanggal').html(row.data.tanggal)
							$('#text-jam').html(row.data.jam)
							$('#text-status').html(row.data.status)
							$('#text-status').attr('class', css_status_telat)
							$('#text-nama-siswa').html(row.data.nama_siswa)
							$('#text-kelas').html(row.data.kelas)
							$('#text-nisn').html(row.data.nisn)
							$('#text-jenis-kelamin').html(row.data.jenis_kelamin)
							$('#image-siswa').attr('src', `<?= base_url('storage/foto_profile_siswa/') ?>${row.data.foto_profile}`)

							$(`.profile__alert-warning`).fadeOut()
							$(`.profile__alert-error`).fadeOut()
							$(`.profile__loading`).hide()
							$(`.content__information`).fadeIn()

							send_wa(row.data, status_wa)
						}else if (row.result == 'check') {
							$(`.profile__alert-warning`).fadeIn()
							$(`.profile__alert-error`).fadeOut()
							$(`.profile__loading`).hide()
							$('.profile__detail-header').css('background-color', 'rgb(250 204 21)')
						} else if (row.result == 'false') {
							$(`.profile__alert-warning`).fadeOut()
							$(`.profile__alert-error`).fadeIn()
							$(`.profile__loading`).hide()
							$('.profile__detail-header').css('background-color', 'rgb(239 68 68)')
						}
					},
					complete: function (data) {
						setTimeout(delay, 3000)
					}
				})
			}
	    }

		function delay(){
			$(`#input-absen`).attr('readonly', false)
			$(`#input-absen`).val('')
			$(`#input-absen`).focus()
			$(`.content__information`).hide()
			$(`.profile__alert-warning`).fadeOut()
			$(`.profile__alert-error`).fadeOut()
			$(`.profile__loading`).hide()
		}

		function show_loading(param) {
			let loading = `<div style="text-align: center;margin-top: 5rem;">
				<img src="<?= base_url('assets/loading-table.gif') ?>" alt="<?= base_url('assets/loading-table.gif') ?>" width="70">
			<div>`

			$(`${param}`).html(loading)
		}

		function send_wa(data, status_absen) {
			let no_telp_wali = data.no_telp_wali
			let nama_siswa = data.nama_siswa
			let kelas = data.kelas
			let jam = data.jam

			$.ajax({
				url: '<?= base_url('landing/absen_siswa/send_wa') ?>',
				method: 'GET',
				data: {no_telp_wali, nama_siswa, kelas, jam, status_absen},
				dataType: 'json',
				success: function (row) {
					console.log(row)
				}
			})
		}

	</script>
</body>
</html>
