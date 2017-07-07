<form method="post" action="/main" id="mainform">
<div class="well">
  <div class="row">
    <div class="col-sm-2 col-md-1">
      Name:
    </div>
    <div class="col-sm-9">
      <input name="name" type="text" size="70" value="<?=$url?>" />
      <input name="name_hidden" type="hidden" value="<?=$url?>" />
      <input name="id_hidden" type="hidden" value="<?=$web_id?>" />
      <br/><button class="btn btn-primary" onclick="window.open('http://www.<?=$url?>', 'newwindow', 'width=1000,height=1000'); return false;">LINK</button>
      &nbsp;&nbsp;&nbsp;(Cmd + W) to close popup window
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-2 col-md-1">
      Desc
    </div>
    <div class="col-sm-9">
      <textarea rows="5" cols="70" name="description" autofocus><?=$desc?></textarea>
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-2 col-md-1">
      Address:
    </div>
    <div class="col-sm-9">
      <textarea rows="5" cols="70" name="address"><?php foreach($contact_info['address'] as $val) { ?>
        <?=$val?><br/><br/>
<?php } ?></textarea>
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-2 col-md-1">
      Phone:
    </div>
    <div class="col-sm-9">
      <textarea rows="5" cols="70" name="phone"><?php 
        echo implode(", ", $contact_info['phone']);
?></textarea>
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-2 col-md-1">
      Email:
    </div>
    <div class="col-sm-9">
      <textarea rows="5" cols="70" name="email"><?php foreach($contact_info['email'] as $val) { ?>
        [<?=$val?>]<br/><br/>
<?php } ?></textarea>
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-1">
      Tags:
    </div>
    <div class="col-sm-9">
      <textarea rows="5" cols="70" name="tags"><?=$tags?></textarea>
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-9">
      <button class="btn btn-primary">SUBMIT</button>
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-1">
      Category
    </div>
    <div class="col-sm-2 col-md-1">
      <input name="category" type="text" value="shoes" readonly>
    </div>
  </div>
  
  <a href="/main/index2" class="btn btn-success">GET OBJ</a>
  
</div>
</form>