
<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="dashboard.html">Dashboard</a></li>
				<li class="active"><?php echo $judul_web; ?></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><small><?php echo $judul_web; ?></small></h1>
			<!-- end page-header -->

			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
              <?php
                echo $this->session->flashdata('msg');
              ?>
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">TESAPI</h4>
                        </div>
                        <div class="panel-body">
                            <a href="tesapi/v/t.html" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah data</a>
                            
                            <hr>
													<div class="table-responsive">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="1%">NO.</th>
                                        <th>NAMA</th>
                                        <th>TANGGAL / JAM</th>
                                        <th>TANGGAL</th>
                                        <th>WAKTU</th>
                                        <th>FILES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $no=1;
                                   foreach ($tesapi as $value): ?>
                                    <tr>
                                        <td><?php echo $no++; ?>.</td>
																				<td><?php echo ucwords($value['nama']); ?></td>
                                        <td><?php echo $value['tanggaljam']; ?></td>
                                        <td><?php echo $value['tanggal']; ?></td>
                                        <td><?php echo $value['jam']; ?></td>
                                        <td>
                                          <?php foreach ($this->Mcrud->url_data_dukung($value['files']) as $key => $element): ?>
                                            <a href="<?php echo $element; ?>" target="blank"><?php echo $element; ?></a>
                                          <?php endforeach; ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                                
                            </table>
													</div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
