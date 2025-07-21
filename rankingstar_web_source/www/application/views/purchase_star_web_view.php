<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo lang('MSG_WELCOME') ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <style>
    .card {
        box-shadow: none !important;
    }
    .table td {
        border-top: 0 !important;
    }
    .card-header {
        background-color: #f0f0f0 !important;
    }
    .card-title {
        color: #8f8f8f !important;
    }
    .btn-card {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        height: 158px;
        border-radius: 1.5rem !important;
        border: none !important;
    }
    .bg-pink { 
        /* background-color: #f262a4 !important; */
        background-color: rgb(255,103,156) !important;
    }
    .bg-orange01 {
        background-color: #F77501 !important;
        color: #fff !important;
    }
    .card-image-sec {
        height: 58px;
        width: 58px;
        background-color: #fff;
        position: relative;
        float: left;
        display: flex;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        margin-top: 10px;
        box-shadow: 0px 0px 5px 0px #948f8f;
    }
    .card-image-sec img {
        height: 34px;
        width: 34px;
        position: absolute;
    }
    p {
        margin-bottom: 0 !important;
    }
    ._fS20 {
        font-size: 1rem;
        padding-bottom: 0.3rem;
    }
    ._fS12 {
        font-size: 0.7rem;
    }
    .card-body {
        padding: 0.8rem 0.8rem 1.6rem !important
    }
    .table td {
        width: 50%;
        padding: .3rem !important;
    }
    .cus-card-header {
        padding: 10px !important;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #F0F0F0 !important;
        color: #000 !important;
        font-size: 18px;
    }
    .cus-card-header span, .cus-card-header p {
        margin-left: 5px;
        margin-right: 5px;
    }
    .rank-count {
        font-size: 20px;
    }
    .bg-image {
        background-image: url('../assets/images/star_background.png');
        background-repeat: no-repeat;
        background-size: 100%;
    }
    .footer-section {
        padding: 1.8rem;
        font-size: 0.9rem;
        background-color: #F0EDED;
    }
    .footer-section  ul {
        padding: 0;
    }
    .footer-section  ul li {
        list-style-type: disc;
    }
    /* .footer-section  ul li::before {
        content: "";
        padding-right: 0.5rem;
    } */
  </style>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/webview.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- ./row -->
        <div class="row">
        <div class="">
            <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">
                  My Star
                </h3>
              </div> -->
              <div class="card-body pad table-responsive">
                <input type="hidden" id="os" value="<?php echo $os;?>">
                <!-- <div class="card-header cus-card-header">
                    <p>My스타</p>
                    <img class="" src="<?php // echo CON_IMAGES_PATH ?>star.png" alt="">
                    <span class="rank-count">100</span>
                    <span>개</span>
                </div> -->
                <table class="table text-center">
                  <tbody>
                    <tr>
                      <td>
                        <button type="button" class="btn btn-block btn-card bg-pink bg-image" id="btn-toll">
                        <!-- Toll charging station -->
                            <div class="card-image-sec">
                                <img class="" src="<?php echo CON_IMAGES_PATH ?>star.png" alt="">
                            </div>
                            <p class="_fS20">유료 충전소</p>
                            <!-- <p class="_fS12">충전한 스타로 원하는 참가자에서 투표하세요!</p> -->
                            <p class="_fS12">스타 충전하고 지금 바로 <br>투표하세요!</p>
                        </button>
                      </td>
                      <td>
                        <button type="button" class="btn btn-block btn-card bg-orange01 bg-image" id="btn-attendance">
                            <!-- Attendance check -->
                            <div class="card-image-sec">
                                <img class="" src="<?php echo CON_IMAGES_PATH ?>star.png" alt="">
                            </div>
                            <p class="_fS20">출석체크</p>
                            <!-- <p class="_fS12">매일 매일 출석체크하여 스타를 받아가세요!</p> -->
                            <p class="_fS12">매일 출석체크하고 무료 <br>스타 받아가세요!</p>
                        </button>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-card bg-orange01 bg-image" id="btn-free-charging">
                                <!-- Free charging station -->
                                <div class="card-image-sec">
                                    <img class="" src="<?php echo CON_IMAGES_PATH ?>star.png" alt="">
                                </div>
                                <p class="_fS20">무료 충전소</p>
                                <!-- <p class="_fS12">동영상을 시청하면 스타가 10개 증정됩니다!(하루 최대 5회)</p> -->
                                <p class="_fS12">제휴사 광고보고 무료 스타 <br>받아가세요!</p>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-card bg-pink bg-image" id="btn-shop">
                                <!-- Star shop -->
                                <div class="card-image-sec">
                                    <img class="" src="<?php echo CON_IMAGES_PATH ?>star.png" alt="">
                                </div>
                                <p class="_fS20">스타샵</p>
                                <!-- <p class="_fS12">물건을 구입하고 스타를 받아가세요!</p> -->
                                <p class="_fS12">제휴사 상품 구매하면 무료 <br>스타가 펑펑 쏟아집니다!</p>
                            </button>
                        </td>
                    </tr>
                    <tr>
                    <td>
                            <button type="button" class="btn btn-block btn-card bg-pink bg-image" id="btn-gift">
                                <!-- Gift -->
                                <div class="card-image-sec">
                                    <img class="" src="<?php echo CON_IMAGES_PATH ?>star.png" alt="">
                                </div>
                                <!-- <p class="_fS20">선물하기</p> -->
                                <p class="_fS20">스타선물하기</p>
                                <!-- <p class="_fS12">특별한 날, 스타를 선물하세요!</p> -->
                                <p class="_fS12">내가 보유한 스타를 <br>친구에게 선물하세요!</p>
                            </button>
                        </td>
                        <td>
                            <!-- Coupon charging station -->
                            <?php if($os == "Android" ): ?>
                            <button type="button" class="btn btn-block btn-card bg-orange01 bg-image" id="btn-coupon">
                                <div class="card-image-sec">
                                    <img class="" src="<?php echo CON_IMAGES_PATH ?>star.png" alt="">
                                </div>
                                <p class="_fS20">쿠폰 충전소</p>
                                <p class="_fS12">충전한 쿠폰으로 참가자에게 투표하세요!</p>
                            </button>
                            <?php endif; ?>
                        </td>
                        
                    </tr>
                  </tbody>
                </table>
                <!-- <div class="card-footer cus-card-footer">
                    
                </div> -->
              </div>
              <!-- /.card -->
                <div class="footer-section">
                    <ul>
                        <li>무료 충전소에서 지급된 마이스타는 시청 후 바로 지급됩니다.</li>
                        <li>출석체크 하여 지급된 마이스타는 출석체크 완료 시 지급됩니다</li>
                        <li>지급되는 마이스타는 제공사의 정책에 따라 반영이 다소 늦어질 수 있습니다.</li>
                    </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo CON_DIST_PATH; ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo CON_DIST_PATH; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo CON_DIST_PATH; ?>js/adminlte.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn-toll').click(function() {
          $id = $(this).attr('id');
          $os = $('#os').val();
          if($os == "iOS"){
            window.webkit.messageHandlers.callbackHandler.postMessage($id);            
          }else{
            Android.showToast($id);
          }          
        });

        $('#btn-attendance').click(function(){
          $(this).attr('disabled',true);
          setTimeout(function() {
            $('#btn-attendance').attr('disabled',false);
          },2000);   // enable after 2 seconds
          console.log('Attendance Click');
          $id = $(this).attr('id');
          $os = $('#os').val();
          if($os == "iOS"){
            window.webkit.messageHandlers.callbackHandler.postMessage($id);            
          }else{
            Android.showToast($id);
          }          
        });

        $('#btn-free-charging').click(function(){
          console.log('Free Charge Click');
          $id = $(this).attr('id');
          $os = $('#os').val();
          if($os == "iOS"){
            window.webkit.messageHandlers.callbackHandler.postMessage($id);            
          }else{
            Android.showToast($id);
          }          
        });

        $('#btn-shop').click(function(){
          console.log('Btn Star Shop Click');
          $id = $(this).attr('id');
          $os = $('#os').val();
          if($os == "iOS"){
            window.webkit.messageHandlers.callbackHandler.postMessage($id);            
          }else{
            Android.showToast($id);
          }          
        });

        $('#btn-coupon').click(function(){
          console.log('Coupon Click');
          $id = $(this).attr('id');
          $os = $('#os').val();
          if($os == "iOS"){
            window.webkit.messageHandlers.callbackHandler.postMessage($id);            
          }else{
            Android.showToast($id);
          }          
        });

        $('#btn-gift').click(function(){
          console.log('Gift Click');
          $id = $(this).attr('id');
          $os = $('#os').val();
          if($os == "iOS"){
            window.webkit.messageHandlers.callbackHandler.postMessage($id);            
          }else{
            Android.showToast($id);
          }          
        });
    });

</script>
</body>
</html>
