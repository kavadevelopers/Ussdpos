<div class="page-header">
    <div class="align-items-end">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4><?= $_title ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <a href="<?= base_url('agent/'.$page) ?>" class="btn btn-danger btn-mini">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="card">
        <form method="post" action="<?= base_url('agent/update') ?>" enctype="multipart/form-data" id="editAgent">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>BVN <span class="-req">*</span></label>
                            <input name="bvn" type="text" class="form-control" value="<?= set_value('bvn',$item->bvn); ?>" placeholder="BVN">
                            <?= form_error('bvn') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Full Name <span class="-req">*</span></label>
                            <input name="name" type="text" class="form-control" value="<?= set_value('name',$item->name); ?>" placeholder="Full Name">
                            <?= form_error('name') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gender <span class="-req">*</span></label>
                            <select class="form-control" name="gender">
                                <option value="">-- Select Gender --</option>
                                <option value="Male" <?= selected($item->gender,'Male') ?>>Male</option>
                                <option value="Female" <?= selected($item->gender,'Female') ?>>Female</option>
                                <option value="Other" <?= selected($item->gender,'Other') ?>>Other</option>
                            </select>
                            <?= form_error('gender') ?>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile number <span class="-req">*</span></label>
                            <input name="phone" type="text" class="form-control numbers" value="<?= set_value('phone',$item->phone); ?>" placeholder="Mobile number">
                            <?= form_error('phone') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email <span class="-req">*</span></label>
                            <input name="email" type="text" class="form-control" value="<?= set_value('email',$item->email); ?>" placeholder="Email">
                            <?= form_error('email') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Business Name <span class="-req">*</span></label>
                            <input name="business" type="text" class="form-control" value="<?= set_value('business',$item->business); ?>" placeholder="Business Name">
                            <?= form_error('business') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bank Account no. <span class="-req">*</span></label>
                            <input name="bankac" type="text" class="form-control numbers" value="<?= set_value('bankac',$item->detail->bankac); ?>" placeholder="Bank Account no.">
                            <?= form_error('bankac') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bank <span class="-req">*</span></label>
                            <select class="form-control select2" name="bank">
                                <option value="">-- Select --</option>
                                <?php foreach ($this->general_model->getRegBanks() as $key => $value) { ?>
                                    <option value="<?= $value->name ?>" <?= selected($item->detail->bank,$value->name) ?>><?= $value->name ?></option>
                                <?php } ?>
                            </select>
                            <?= form_error('bank') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>NIN <span class="-req">*</span></label>
                            <input name="nin" type="text" class="form-control numbers" value="<?= set_value('nin',$item->detail->nin); ?>" placeholder="NIN">
                            <?= form_error('nin') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Employment Type <span class="-req">*</span></label>
                            <select class="form-control" name="emp">
                                <option value="">-- Select --</option>
                                <option value="Salaried" <?= selected($item->detail->emp,'Salaried') ?>>Salaried</option>
                                <option value="Self employed" <?= selected($item->detail->emp,'Self employed') ?>>Self employed</option>
                                <option value="Retired" <?= selected($item->detail->emp,'Retired') ?>>Retired</option>
                            </select>
                            <?= form_error('emp') ?>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type Of Agent <span class="-req">*</span></label>
                            <select class="form-control" name="agent">
                                <option value="">-- Select --</option>
                                <option value="Office" <?= selected($item->detail->agent,'Office') ?>>Office</option>
                                <option value="Shop" <?= selected($item->detail->agent,'Shop') ?>>Shop</option>
                                <option value="Physical" <?= selected($item->detail->agent,'Physical') ?>>Physical</option>
                                <option value="Roaming" <?= selected($item->detail->agent,'Roaming') ?>>Roaming</option>
                                <option value="Individual" <?= selected($item->detail->agent,'Individual') ?>>Individual</option>
                            </select>
                            <?= form_error('agent') ?>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State <span class="-req">*</span></label>
                            <select class="form-control select2" name="state">
                                <option value="">-- Select --</option>
                                <?php foreach ($this->general_model->getStates() as $key => $value) { ?>
                                    <option value="<?= $value->name ?>" <?= selected($item->detail->state,$value->name) ?>><?= $value->name ?></option>
                                <?php } ?>
                            </select>
                            <?= form_error('state') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City(LGA) <span class="-req">*</span></label>
                            <input name="city" type="text" class="form-control" value="<?= set_value('city',$item->detail->city); ?>" placeholder="City(LGA)">
                            <?= form_error('city') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address <span class="-req">*</span></label>
                            <textarea name="address" type="text" class="form-control" value="" placeholder="Address"><?= set_value('address',$item->detail->address); ?></textarea>
                            <?= form_error('address') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Identification Type <span class="-req">*</span></label>
                            <select class="form-control" name="idtype">
                                <option value="">-- Select --</option>
                                <option value="NIN/ National ID Card" <?= selected($item->detail->idtype,'NIN/ National ID Card') ?>>NIN/ National ID Card</option>
                                <option value="Voter\'s Card" <?= selected($item->detail->idtype,'Voter\'s Card') ?>>Voter's Card</option>
                                <option value="Driver\'s license" <?= selected($item->detail->idtype,'Driver\'s license') ?>>Driver's license</option>
                                <option value="International Passport" <?= selected($item->detail->idtype,'International Passport') ?>>International Passport</option>
                            </select>
                            <?= form_error('idtype') ?>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ID number <span class="-req">*</span></label>
                            <input name="idnum" type="text" class="form-control" value="<?= set_value('idnum',$item->detail->idnum); ?>" placeholder="ID number">
                            <?= form_error('idnum') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Photograph</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="photo" type="file" class="form-control">
                                    <?= form_error('photo') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileprofile) ?>">
                                    <img src="<?= $item->detail->fileprofile ?>" style="max-width: 100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">Address Verification</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="fileaddress" type="file" class="form-control">
                                    <?= form_error('fileaddress') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileaddress) ?>">
                                    <img src="<?= $item->detail->fileaddress ?>" style="max-width: 100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-saparater">ID Verification</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="fileid" type="file" class="form-control">
                                    <?= form_error('fileid') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileid) ?>">
                                    <img src="<?= $item->detail->fileid ?>" style="max-width: 100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="card-footer text-right">
                <input type="hidden" name="main" value="<?= $item->id ?>">
                <input type="hidden" name="type" value="<?= $this->uri->segment(4) ?>">
                <a href="<?= base_url('agent/'.$page) ?>" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(function(){
        flag = 0;
        $('#editAgent').submit(function(){
            if ($("input[name=bvn]").val() == "") {
                PNOTY('Please enter BVN','error');
                return false;
            }else if ($("input[name=name]").val() == "") {
                PNOTY('Please enter Full name','error');
                return false;
            }else if ($("select[name=gender]").val() == "") {
                PNOTY('Please select gender','error');
                return false;
            }else if ($("input[name=phone]").val() == "") {
                PNOTY('Please enter Mobile','error');
                return false;
            }else if ($("input[name=email]").val() == "") {
                PNOTY('Please enter Email','error');
                return false;
            }else if ($("input[name=business]").val() == "") {
                PNOTY('Please enter Business name','error');
                return false;
            }else if ($("input[name=bankac]").val() == "") {
                PNOTY('Please enter Bank Ac. No.','error');
                return false;
            }else if ($("select[name=bank]").val() == "") {
                PNOTY('Please select Bank','error');
                return false;
            }else if ($("input[name=nin]").val() == "") {
                PNOTY('Please enter NIN','error');
                return false;
            }else if ($("select[name=emp]").val() == "") {
                PNOTY('Please select Employment Type','error');
                return false;
            }else if ($("select[name=agent]").val() == "") {
                PNOTY('Please select Type Of Agent','error');
                return false;
            }else if ($("select[name=state]").val() == "") {
                PNOTY('Please select State','error');
                return false;
            }else if ($("input[name=city]").val() == "") {
                PNOTY('Please enter City','error');
                return false;
            }else if ($("input[name=address]").val() == "") {
                PNOTY('Please enter Address','error');
                return false;
            }else if ($("select[name=idtype]").val() == "") {
                PNOTY('Please select Identification Type','error');
                return false;
            }else if ($("input[name=idnum]").val() == "") {
                PNOTY('Please enter ID number','error');
                return false;
            }else{
                if (flag == 0) {
                    showAjaxLoader();
                    $.post("<?= base_url('agent/validate_edit') ?>", $.param($('#editAgent').serializeArray()),
                        function(result){
                            hideAjaxLoader();
                            if (result._return) {
                                flag = 1;
                                $('#editAgent').submit();
                            }else{
                                flag = 0;
                                PNOTY(result.msg,'error');  
                            }
                        }
                    );
                    return false;
                }
            }
        });
    })
</script>