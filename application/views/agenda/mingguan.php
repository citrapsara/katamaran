<ul class="m-0 p-0">
  <?php
    $ceks 	 = $this->session->userdata('token_katamaran');
    $id_user	= $this->session->userdata('id_user');
    $level	= $this->session->userdata('level');
    if ($agenda != null):
      $temp = '1996-01-01'; ?>
      <div class="bgc-blue-50 c-blue-500 p-10"></div>
  <?php foreach ($agenda as $row):
        if ($temp != $row['tanggal']) {
          ?>
    <div class="bgc-blue-50 c-blue-500 pX-20 pT-15 pB-10">
      <h5><?php echo $this->Mcrud->hari_id($row['tanggal']) . ', ' . $this->Mcrud->tgl_id($row['tanggal'], 'full'); ?></h5>
    </div>
    <?php $temp = $row['tanggal']; } ?>
    <li class="bdB peers ai-c jc-sb fxw-nw list-jadwal">
      <a
        class="td-n p-20 peers fxw-nw mR-20 peer-greed c-grey-900 link-agenda"
        href="javascript:void(0);"
        data-toggle="modal"
        data-target="#detail_agenda<?php echo $row['id']; ?>"
        ><div class="peer mR-15">
          <i class="fa fa-fw fa-clock-o c-green-500"></i>
        </div>
        <div class="peer wrap-text-agenda">
          <span class="fw-600"><?php echo $row['nama']; ?></span>
          <div class="c-grey-600">
            <span class="c-grey-700"><?php echo $this->Mcrud->jam($row['jam_mulai']); ?> - </span
            ><i><?php echo $row['tempat'] ?></i>
          </div>
          <div class="c-grey-600">
            <span class="c-grey-700"><?php echo $row['pakaian']; ?></span>
          </div>
          <div class="c-grey-600">
            <span class="c-grey-700"><?php echo $row['peserta']; ?></span>
          </div>
        </div></a
      >
      <div class="peers mR-15">
        <?php 
          if(isset($ceks)):        
          if($level == 'superadmin' OR $level == 'sekpim' OR $row['id_user'] == $id_user): ?>
        <div class="peer">
          <a
            href=""
            class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5"
            data-toggle="modal"
            data-target="#edit_agenda<?php echo $row['id']; ?>"
            ><i class="ti-pencil"></i
          ></a>
        </div>
        <div class="peer">
          <a
            href=""
            class="td-n c-red-500 cH-blue-500 fsz-md p-5"
            data-toggle="modal"
            data-target="#delete_agenda<?php echo $row['id']; ?>"
            ><i class="ti-trash"></i
          ></a>
        </div>
        <?php endif; endif; ?>
      </div>
    </li>
    <?php endforeach;
    else : ?>
      <div class="p-10"></div>
      <div class="p-20"><h6 class="ta-c fsz-sm">-- Belum ada agenda --</h6></div>
    <?php endif; ?>
  </ul>
    