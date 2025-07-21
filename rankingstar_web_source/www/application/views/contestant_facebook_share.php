<?php if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $url = "https"; 
else
    $url = "http"; 
  
// Here append the common URL characters. 
$url .= "://"; 
  
// Append the host(domain name, ip) to the URL. 
$url .= $_SERVER['HTTP_HOST']; 
  
// Append the requested resource location to the URL 
$url .= $_SERVER['REQUEST_URI']; 
       
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ranking Star</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>fonts/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/adminlte.min.css">

  <!-- jQuery -->
  <script src="<?php echo CON_DIST_PATH ?>jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo CON_DIST_PATH ?>bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo CON_DIST_PATH ?>js/adminlte.js"></script>
  <!-- Meta Tag For Facebook Sharing -->
  <meta property="og:url"           content="<?php echo $url; ?>" />
  <meta property="og:type"          content="profile" />
  <!-- <meta property="og:title"         content="<?php //echo $contestant_details['name'] . '( '.$contestant_details['contest_name'].' )';?>" /> -->
  <!-- <meta property="og:description"   content="<?php //echo $contestant_details['introduction'];?>" /> -->
  <meta property="og:title"         content="<?php if($language == "english"){ echo "Please support {$contestant_details['name']} at the {$contestant_details['contest_name']}."; }else{ echo "{$contestant_details['contest_name']} - {$contestant_details['name']} 참가자를 응원해주세요";}?>" />
  <meta property="og:description"   content="Download the Rankingstar app." />
  <meta property="og:image"         content="<?php echo $contestant_details['main_image'];?>" />
  <meta property="fb:app_id"        content="<?php echo FACEBOOK_APP_ID;?>" />
  <meta property="al:android:url" content="share://contestant?contest_id=<?php echo $contestant_details['contest_id'];?>&contestant_id=<?php echo $contestant_details['contestant_id'];?>"> 
  <meta property="al:android:package" content="com.etech.starranking"> 
  <meta property="al:android:app_name" content="Ranking Star">
  <meta property="al:web:should_fallback" content="false">
  <meta property="al:ios:url" content="share://contestant?contest_id=<?php echo $contestant_details['contest_id'];?>&contestant_id=<?php echo $contestant_details['contestant_id'];?>" />
  <meta property="al:ios:app_store_id" content="<?php echo APP_STORE_ID;?>" />
  <meta property="al:ios:app_name" content="Ranking Star/>
</head>
<body>
</body>
</html>

<!DOCTYPE html>
<html>
<body class="hold-transition">
<div class="wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">

            <!-- Profile Image -->
            <div class="card card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?php echo $contestant_details['main_image'];?>" alt="User profile picture" style="width: 250px !important;height: 250px!important;">
                </div>

                <h3 class="profile-username text-center"><?php echo $contestant_details['name'] ?></h3>

                <p class="text-muted text-center"><?php echo $contestant_details['contest_name'];?></p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b><?php echo lang('MSG_TOTAL_VOTE');?></b> <a class="float-right"><?php echo $contestant_details['total_vote']?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?php echo lang('MSG_ABOUT_ME');?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-birthday-cake"></i> <?php echo lang('MSG_AGE');?></strong>
                <p class="text-muted">
                  <?php echo $contestant_details['age']?>
                </p>
                <hr>
                <strong><i class="fas fa-arrows-alt-v"></i> <?php echo lang('MSG_HEIGHT');?></strong>
                <p class="text-muted"><?php echo $contestant_details['height']?></p>
                <hr>
                <strong><i class="fas fa-weight"></i> <?php echo lang('MSG_WEIGHT');?></strong>
                <p class="text-muted"><?php echo $contestant_details['weight']?></p>
                <hr>
                <!-- <strong><i class="fas fa-pencil-alt mr-1"></i> Skill</strong>
                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>
                <hr> -->
                <strong><i class="fas fa-address-card"></i> <?php echo lang('MSG_INTRO');?></strong>
                <p class="text-muted"><?php echo $contestant_details['introduction']?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-3"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
