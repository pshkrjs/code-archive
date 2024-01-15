<?php 
include 'template_header.php';
if (isset($_GET['id'])) {
    $collection = $db->user;
    $document = $collection->findOne(array('_id'=>new MongoId($_GET['id'])));
    if($document){
      ?>


<div class="row"></div>
<div id="announcement_page" class="col l12">
  <div class="row"></div>
  <div class="row">
    <div class="col l6 offset-l3">
      <div class="card">
        <div class="card-content black-text">
          <div class="row"><br>
            <span class="card-title black-text">User Details</span>
            <!-- <img class="responsive-img" src="images/profile.gif" style="float:right"> -->
          </div>
          <form class="col s12">
            <div class="row">
              <div class="input-field col s10" >
                <label1 style="color: #40c4ff" for="name">Name: </label1><?php echo $document['name'] ; ?>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s10">
                  <label1 style="color: #40c4ff" for="date">Date of birth: </label1><?php echo date('d-M-Y', $document['dob']->sec);?>
                </div>
            </div>
            <div class="row">
            <div class="input-field col s10">
              <label1 style="color: #40c4ff" for="gender">Gender: </label1><?php echo $document['gender']; ?>
              </div>
            </div>
            <div class="row">
              <div class="input-field  col  s12">
                <label1 style="color: #40c4ff" for="email">Email Id: </label1><?php echo $document['email']; ?>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s10">
                <label1 style="color: #40c4ff" for="phone">Contact Number: </label1><?php echo $document['mobile']; ?>
              </div>              
            </div>
            <div class="row">
              <div class="input-field col s12">
                <label1 style="color: #40c4ff"for="address">Address: </label1><?php echo $document['address']; ?>
              </div>
            </div>
            <?php
            if($document['type'] == 'student')
            {
            ?>
            <div class="row">
               <div class="input-field col s12">
                 <label1 style="color: #40c4ff" for="student_department">Department: </label1><?php echo strtoupper($document['department']); ?>
                </div>
              </div>
            <div class="row">
               <div class="input-field col s4">
                 <label1 style="color: #40c4ff" for="yoa">Year Of Admission: </label1><?php echo $document['yoa']; ?>
                </div>
              </div>
              <div class="row"></div>
              <div class="row"></div>
            <div class="row">
              <span class="card-title black-text">Parent Details</span>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <label1 style="color: #40c4ff" for="fat_name">Father's Name: </label1><?php echo $document['fathers_name']; ?>
              </div>
              <div class="input-field col s6">
                <label1 style="color: #40c4ff" for="fat_mob"> Mobile Number: </label1><?php echo $document['fathers_mobile']; ?>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <label1 style="color: #40c4ff" for="mot_name">Mother's Name: </label1><?php echo $document['mothers_name']; ?>
              </div>
              <div class="input-field col s6">
                <label1 style="color: #40c4ff" for="mot_mob"> Mobile Number: </label1><?php echo $document['mothers_mobile']; ?><br><br>
              </div>
              <?php
        }
        else
        {
          ?>
            <div class="row">
               <div class="input-field col s10">
                 <label1 style="color: #40c4ff" for="yoa">Started Teaching From: </label1><?php echo $document['yoa']; ?>
                </div>
              </div>
              <div class="row">
               <div class="input-field col s10">
                 <label1 style="color: #40c4ff" for="qualification">Qualifications: </label1><?php echo $document['qualification']; ?>
                </div>
              </div>
              <div class="row">
               <div class="input-field col s12">
                 <label1 style="color: #40c4ff" for="department">Department: </label1><?php echo strtoupper($document['department']); ?>
                </div>
              </div>
            <div class="row">
              <div class="input-field col s12">
                <label1 style="color: #40c4ff" for="subjects">Subjects Taught: </label1><?php foreach ($document['subjects'] as $sub) {
                  echo $sub." ";
                } ?>
              </div>
              <div class="row"></div>
              <div class="row"></div>
          <?php
        }
        ?>
        </form>
        <?php
        }
        ?>
        </div>
        </div>
        </div>
      
  </div>
  </div>
  <?php
}
?>

        
<?php include "template_footer.html"; ?>
