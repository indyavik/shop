<style type="text/css">
.tg-left { text-align: left; } .tg-right { align="right"; text-align: right; } .tg-center { text-align: center; }
.tg-bf { font-weight: bold; } .tg-it { font-style: italic; }
.tg-table-plain { border-collapse: collapse; border-spacing: 0; font-size: 100%; font: inherit; }
.tg-table-plain td, .tg-table-plain th { border: 1px #555 solid; padding: 10px; vertical-align: top;font-size: 10px;text-transform:uppercase; }
.formdata{font-weight:bold;font-size:12px;}
.ship{font-weight:bold;font-size:14px; color:#606060; }
.big{font-weight:bold;font-size:14px;}
.shade {background-color: #B0C4DE;}
.min { min-width: 200px; }

</style>
<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm" style="font-size: 12pt">

  <div style="min-width: 900px;">
    <div style="float: left; margin: 0 0 1.5em 0;">

      <img src="http://cdn.shopify.com/s/files/1/0158/6542/t/9/assets/logo.png?2270" alt="dd_sg Logo">

    </div>

  <!--   <div style="float: right; margin: 0 0 1.5em 0;">
      <p>Attn:</p>
      <p>Concerned Person</p>
      <p>Name of the Lab</p>
    </div> -->


  </div>


<!--<table>
  <tr>
    <td>
      <div>
      <img src="http://cdn.shopify.com/s/files/1/0158/6542/t/9/assets/logo.png?2270" alt="dd_sg Logo">

      </div>
    </td>

    <td class="tg-right">
      <div>
      <p>Attn:</p>
      <p>Concerned Person</p>
      <p>Name of the Lab</p>

      </div>
    </td>


  </tr>
</table> -->

<hr>
<p>

</p>
<h2>Frame Id: <?php echo $pid ?> </h2>
<h3>Order Number: <?php echo $oid ?></h3>

<!-- <table width="100%" >


<tr>
  <td  class="tg-left min"  >
    <h2>Frame Id: <?php echo $pid ?> </h2>
    <h5>Order Number: <?php echo $oid ?></h5>
  </td>
  <td class="tg-bf tg-it tg-right">
    <h3>Ship To: </h3>
    <?php echo $cname ?>
    <?php echo $address1 ?>
    <?php echo $address2 ?>
    <?php echo $city?>,<?php echo $province ?>
    <?php echo $zip?>,<?php echo $country ?>

  </td>

</tr>

</table> -->


<table class="tg-table-plain" width="100%">
<tr>
  <td class="shade min"></td>
  <td>Sphere</td>
  <td>Cylinder</td>
  <td>Axis</td>
  <td>Add</td>

</tr>
<tr class="tg-even">
  <td>Right(OD)&nbsp;</td>
  <td><span class="formdata"><?php echo $od_sph ?></span></td>
  <td><span class="formdata"><?php echo $od_cyl ?></span></td>
  <td><span class="formdata"><?php echo $od_axis ?></span></td>
  <td><span class="formdata"><?php echo $od_add ?></span></td>

</tr>
<tr>
  <td>Left(OS)</td>
  <td><span class="formdata"><?php echo $os_sph ?></span></td>
  <td><span class="formdata"><?php echo $os_cyl ?></span></td>
  <td><span class="formdata"><?php echo $os_axis ?></span></td>
  <td><span class="formdata"><?php echo $os_add ?></span></td>

</tr>

<tr>
  <td>
    <span class="big">PD: <?php echo $pd_sph ?> </span>

  </td>
</tr>

</table>

<p> <span class="formdata">Index: 1.60 or 1.67 index </span> </p>
<h3>Ship To:</h3>
<p class="ship"><?php echo $cname ?></p>
<span class="ship"><?php echo $address1 ?></span>
<p class="ship"><?php echo $address2 ?></p>
<span class="ship"><?php echo $city?>,<?php echo $province ?></span>
<p class="ship"><?php echo $zip?>,<?php echo $country ?></p>

<p>

</p>

<h2>Remarks for lab</h2>

<table class="tg-table-plain" width="500px" >

  <?php $commentWrap = wordwrap($comment, 70, "<br />\n"); ?>

<tr>
  <td colspan="5" style="height:80px; "><span class="formdata"><?php echo $commentWrap ?></span></td>

</tr>
</table>
<p>

</p>

<p>

</p>
<page_footer>
<div style="height:2px;background-color:blue;border-bottom: 1px solid red"></div>
       <b><i><div style="font-size:10px; color:black;">Created for Lab name and address </div></i></b>
</page_footer>
</page>
