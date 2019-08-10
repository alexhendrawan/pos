<nav class="page-sidebar" data-pages="sidebar">


	<div class="sidebar-header">
		<img src="#" alt="CV. Kemilau Mentari" data-src="#" width="180" height="auto">
	</div>


	<div class="sidebar-menu">
		<ul class="menu-items ul-style">
			<li class="">
				<a href="{{ url("/") }}" class="detailed">
					<span>Dashboard</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
			</li>

			<li class="">
				<a href="javascript:;"><span class="title">Penjualan</span>
					<span class=" arrow"></span></a>
				<span class="icon-thumbnail"><i class="pg-calender"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("penjualan/create") }}">Buat Faktur</a>
						<span class="icon-thumbnail">O</span>
					</li>
					<li>
						<a href="{{ url("penjualan") }}">Lihat Faktur</a>
						<span class="icon-thumbnail">O</span>
					</li>
					<li>
						<a href="javascript:;"><span class="title">Piutang</span>
							<span class=" arrow"></span></a>
						<span class="icon-thumbnail"><i class="pg-calender"></i></span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("piutang/create") }}">Buat Pembayaran</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("piutang") }}">Lihat Pembayaran</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:;"><span class="title">Retur Penjualan</span>
							<span class=" arrow"></span></a>
						<span class="icon-thumbnail"><i class="pg-calender"></i></span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("retur-penjualan/create") }}">Buat Retur</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("retur-penjualan") }}">Lihat Retur</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:;"><span class="title">Pembelian</span>
					<span class=" arrow"></span></a>
				<span class="icon-thumbnail"><i class="pg-calender"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="javascript:"><span class="title">PO</span>
							<span class="arrow"></span></a>
						<span class="icon-thumbnail">L2</span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("po") }}">Lihat PO</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("po/create") }}">Buat PO</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("po?riwayat=true") }}">Riwayat PO</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:"><span class="title">Penerimaan</span>
							<span class="arrow"></span></a>
						<span class="icon-thumbnail"></span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("penerimaan") }}">Lihat Penerimaan</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("penerimaan?riwayat=true") }}">Riwayat Penerimaan</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:"><span class="title">Hutang</span>
							<span class="arrow"></span></a>
						<span class="icon-thumbnail">L2</span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("hutang/create") }}">Buat Pembayaran</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("hutang") }}">Lihat Pembayaran</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript:"><span class="title">Retur Pembelian</span>
							<span class="arrow"></span></a>
						<span class="icon-thumbnail">L2</span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("retur-pembelian/create") }}">Buat Retur</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("retur-pembelian") }}">Lihat Retur</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
				</ul>
			</li>

			<li>
				<a href="javascript:;"><span class="title">Pengeluaran</span>
					<span class=" arrow"></span></a>
				<span class="icon-thumbnail"><i class="pg-calender"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("pengeluaran/create") }}">Buat Pengeluaran</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("pengeluaran") }}">Lihat Pengeluaran</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="javascript:"><span class="title">Kat. Pengeluaran</span>
							<span class="arrow"></span></a>
						<span class="icon-thumbnail">L2</span>
						<ul class="sub-menu">
							<li>
								<a href="{{ url("kategoripengeluaran/create") }}">Buat Kategori</a>
								<span class="icon-thumbnail">O</span>
							</li>
							<li>
								<a href="{{ url("kategoripengeluaran") }}">Lihat Kategori</a>
								<span class="icon-thumbnail">O</span>
							</li>
						</ul>
					</li>
				</ul>
			</li>

			<li class="">
				<a href="#"><span class="title">Master</span></a>
			</li>

			<li>

				<a href="javascript:"><span class="title ">Gudang</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-procedures"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("gudang") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("gudang/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Merk</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-clinic-medical"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("merk") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("merk/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Kategori</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-clinic-medical"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("kategori") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("kategori/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Barang</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-clinic-medical"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("barang") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("barang/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Stok Barang</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-clinic-medical"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("stok") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("stok/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Konsumen</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-capsules"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("konsumen") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("konsumen/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Supplier</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-briefcase"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("supplier") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("supplier/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Inventaris</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-users"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("inventaris/") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("inventaris/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Karyawan</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-stethoscope"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("karyawan") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("karyawan/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:"><span class="title ">Jabatan</span>
					<span class="arrow"></span></a>
				<span class="icon-thumbnail"><i class="fas fa-laptop-medical"></i></span>
				<ul class="sub-menu">
					<li>
						<a href="{{ url("role") }}">Lihat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
					<li>
						<a href="{{ url("role/create") }}">Buat Data</a>
						<span class="icon-thumbnail">L1</span>
					</li>
				</ul>
			</li>
			<li>
				<a href="{{ url("report") }}"><span class="title ">Laporan</span>
				</a>
				<span class="icon-thumbnail"><i class="fas fa-file"></i></span>
			</li>
			<li>
				<a href="{{ url("pengaturan") }}"><span class="title ">Pengaturan</span>
				</a>
				<span class="icon-thumbnail"><i class="fas fa-gear"></i></span>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
</nav>
