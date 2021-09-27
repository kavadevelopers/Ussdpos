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
    <div class="row">
        <div class="col-md-12">
            <div class="cover-profile">
                <div class="profile-bg-img">
                    <img class="profile-bg-img img-fluid" src="<?= base_url() ?>asset/assets/images/banner.jpg" alt="bg-img" style="max-height: 200px;">
                    <div class="card-block user-info">
                        <div class="col-md-12">
                            <div class="media-left">
                                <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileprofile) ?>">
                                    <img class="user-img img-radius" src="<?= $item->detail->fileprofile ?>" alt="user-img" style="width: 200px;">   
                                </a>
                            </div>
                            <div class="media-body row">
                                <div class="col-lg-12">
                                    <div class="user-title">
                                        <h2><?= ucfirst($item->name) ?></h2>
                                        <span class="text-white">POS Agent</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tab-header card">
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#personal" role="tab" aria-selected="false">Agent Info</a>
                        <div class="slide"></div>
                    </li>
                    <?php if ($item->df == "") { ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#ver" role="tab" aria-selected="false">Verification</a>
                            <div class="slide"></div>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#devices" role="tab" aria-selected="false">Devices</a>
                        <div class="slide"></div>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                    <div class="card">
                        <div class="card-block">
                            <div class="view-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table m-0 tbl-white-normal">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Full Name</th>
                                                                    <td><?= ucfirst($item->name) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Email</th>
                                                                    <td><?= $item->email ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Mobile no.</th>
                                                                    <td>
                                                                        <?= $item->phone ?> 
                                                                        <a href="https://web.whatsapp.com/send?phone=+234<?= $item->phone ?>" target="_blank">
                                                                            <img src="<?= base_url('asset/images/watsapp.png') ?>" style="width:20px;">
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Gender</th>
                                                                    <td><?= $item->gender ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Business Name</th>
                                                                    <td><?= $item->business ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Address</th>
                                                                    <td><?= $item->detail->address ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">City</th>
                                                                    <td><?= $item->detail->city ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">State</th>
                                                                    <td><?= $item->detail->state ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table m-0 tbl-shopdis">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Updated Balance</th>
                                                                    <td><?= niara().ptPretyAmount($this->dashboard_model->getAgentBalance($item->id)) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">BVN</th>
                                                                    <td><?= $item->bvn ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">NIN</th>
                                                                    <td><?= $item->detail->nin ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Bank</th>
                                                                    <td><?= $item->detail->bank ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Bank Account No.</th>
                                                                    <td><?= $item->detail->bankac ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Employment type</th>
                                                                    <td><?= $item->detail->emp ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Type of agent</th>
                                                                    <td><?= $item->detail->agent ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Identification Type</th>
                                                                    <td><?= $item->detail->idtype ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">ID Number</th>
                                                                    <td><?= $item->detail->idnum ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="ver" role="tabpanel">
                    <form method="post" action="<?= base_url('agent/doc_status') ?>">
                        <div class="card">
                            <div class="card-block">
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12 table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Photo</th>
                                                    <th>Type</th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Passport Photo
                                                    </th>
                                                    <td>
                                                        <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileprofile) ?>">
                                                            <img src="<?= $item->detail->fileprofile ?>" alt="user-img" style="width: 100px;">   
                                                        </a>

                                                        <p>
                                                            <a class="link imageEdit" data-type="profile" href="#" data-uri="<?= $item->detail->fileprofile ?>">Edit Image</a> | 
                                                            <a class="link" href="<?= $item->detail->fileprofile ?>" download="0<?= $item->id ?>-profile.png">Download</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <?php if($item->sphoto == '0'){ ?>
                                                            <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="photos_status" value="1" required>
                                                                        <i class="helper"></i>Approve
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="photos_status" value="0">
                                                                        <i class="helper"></i>Reject
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="passReason" class="form-group" style="display:none;">
                                                                <select class="form-control" name="photo_reason">
                                                                    <option value="">-- Select Reason--</option>
                                                                    <?php foreach (docRejectReasons() as $key => $value) { ?>
                                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php }else if($item->sphoto == '1'){ ?>
                                                            Approved
                                                        <?php }else if($item->sphoto == '2'){ ?>
                                                            Rejected
                                                            <br><br>
                                                            <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="photos_status" value="1" required>
                                                                        <i class="helper"></i>Approve
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="photos_status" value="0">
                                                                        <i class="helper"></i>Reject
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="passReason" class="form-group" style="display:none;">
                                                                <select class="form-control" name="photo_reason">
                                                                    <option value="">-- Select Reason--</option>
                                                                    <?php foreach (docRejectReasons() as $key => $value) { ?>
                                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        ID Verification
                                                    </th>
                                                    <td>
                                                        <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileid) ?>">
                                                            <img src="<?= $item->detail->fileid ?>" alt="user-img" style="width: 100px;">   
                                                        </a>
                                                        <p>
                                                            <a class="link imageEdit" data-type="id" href="#" data-uri="<?= $item->detail->fileid ?>">Edit Image</a> | 
                                                            <a class="link" href="<?= $item->detail->fileid ?>" download="0<?= $item->id ?>-fileid.png">Download</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <?php if($item->sid == '0'){ ?>
                                                            <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="id_status" value="1" required>
                                                                        <i class="helper"></i>Approve
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="id_status" value="0">
                                                                        <i class="helper"></i>Reject
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="idReason" class="form-group" style="display:none;">
                                                                <select class="form-control" name="id_reason">
                                                                    <option value="">-- Select Reason--</option>
                                                                    <?php foreach (docRejectReasons() as $key => $value) { ?>
                                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php }else if($item->sid == '1'){ ?>
                                                            Approved
                                                        <?php }else if($item->sid == '2'){ ?>
                                                            Rejected
                                                            <br><br>
                                                            <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="id_status" value="1" required>
                                                                        <i class="helper"></i>Approve
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="id_status" value="0">
                                                                        <i class="helper"></i>Reject
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="idReason" class="form-group" style="display:none;">
                                                                <select class="form-control" name="id_reason">
                                                                    <option value="">-- Select Reason--</option>
                                                                    <?php foreach (docRejectReasons() as $key => $value) { ?>
                                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Address Verification
                                                    </th>
                                                    <td>
                                                        <a href="#" class="profile-image photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileaddress) ?>">
                                                            <img src="<?= $item->detail->fileaddress ?>" alt="user-img" style="width: 100px;"> 
                                                        </a>
                                                        <p>
                                                            <a class="link imageEdit" data-type="address" href="#" data-uri="<?= $item->detail->fileaddress ?>">Edit Image</a> | 
                                                            <a class="link" href="<?= $item->detail->fileaddress ?>" download="0<?= $item->id ?>-address.png">Download</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <?php if($item->saddress == '0'){ ?>
                                                            <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="address_status" value="1" required>
                                                                        <i class="helper"></i>Approve
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="address_status" value="0">
                                                                        <i class="helper"></i>Reject
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="addressReason" class="form-group" style="display:none;">
                                                                <select class="form-control" name="address_reason">
                                                                    <option value="">-- Select Reason--</option>
                                                                    <?php foreach (docRejectReasons() as $key => $value) { ?>
                                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php }else if($item->saddress == '1'){ ?>
                                                            Approved
                                                        <?php }else if($item->saddress == '2'){ ?>
                                                            Rejected
                                                            <br><br>
                                                            <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="address_status" value="1" required>
                                                                        <i class="helper"></i>Approve
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="address_status" value="0">
                                                                        <i class="helper"></i>Reject
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div id="addressReason" class="form-group" style="display:none;">
                                                                <select class="form-control" name="address_reason">
                                                                    <option value="">-- Select Reason--</option>
                                                                    <?php foreach (docRejectReasons() as $key => $value) { ?>
                                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($item->saddress != '1' || $item->sid != '1' || $item->sphoto != '1'){ ?>
                                <div class="card-footer text-right">
                                    <input type="hidden" name="agent" value="<?= $item->id ?>">
                                    <input type="hidden" name="uri" value="<?= $this->uri->segment(4) ?>">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i> Send</button>
                                </div>      
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="devices" role="tabpanel">
                    <div class="card">
                        <div class="card-block table-responsive">
                            <table class="table table-striped table-bordered table-mini table-dt">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">OS</th>
                                        <th>Device</th>
                                        <th class="text-center">Device Id</th>
                                        <th class="text-center">Logged In At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($devices as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key+1 ?></td>
                                            <td class="text-center"><?= $value->device ?></td>
                                            <td><?= $value->descr ?></td>
                                            <td class="text-center"><?= $value->device_id ?></td>
                                            <td class="text-center"><small><?= getPretyDateTime($value->cat) ?></small></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-danger btn-mini btnLogout" data-id="<?= $value->id ?>">
                                                    Logout
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style type="text/css">
    .tbl-shopdis td{
        white-space: normal;
    }
</style>


<script type="text/javascript">
    $(function(){
        $('input[name=photos_status]').change(function(event) {
            if ($(this).val() == '0') {
                $('#passReason').show();
                $('#passReason').find('select').attr('required','required');
                $('#passReason').find('select').val('');
            }else{
                $('#passReason').hide();
                $('#passReason').find('select').removeAttr('required');
                $('#passReason').find('select').val('');
            }
        });
        $('input[name=id_status]').change(function(event) {
            if ($(this).val() == '0') {
                $('#idReason').show();
                $('#idReason').find('select').attr('required','required');
                $('#idReason').find('select').val('');
            }else{
                $('#idReason').hide();
                $('#idReason').find('select').removeAttr('required');
                $('#idReason').find('select').val('');
            }
        });
        $('input[name=address_status]').change(function(event) {
            if ($(this).val() == '0') {
                $('#addressReason').show();
                $('#addressReason').find('select').attr('required','required');
                $('#addressReason').find('select').val('');
            }else{
                $('#addressReason').hide();
                $('#addressReason').find('select').removeAttr('required');
                $('#addressReason').find('select').val('');
            }
        });
    })
</script>






<script type="text/javascript">
    $(function(){
        $(document).on('click','.btnLogout', function(event){
            event.preventDefault();
            _this = $(this);
            if(confirm('Are you sure?')){
                showAjaxLoader();
                $.post("<?= base_url('agent/logout_device') ?>", 
                    {id: $(this).data('id')}, 
                    function(result){
                        hideAjaxLoader();
                        _this.closest('tr').remove();
                        PNOTY('Logout Success','success');       
                    }
                );
            }
        });
    })
</script>

<!-- Cropper Js -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js" integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script type="text/javascript">
    var cropper;
    $(function(){
        $('.imageEdit').click(function(event) {
            $('input[name=typeOfPhoto]').val($(this).data('type'));
            $('#imgEditBase').attr('src',$(this).data('uri'));
            $('#modalImageEdit').modal('show');
            event.preventDefault();
        });
        $('#modalImageEdit').on('shown.bs.modal', function () {
            cropper = new Cropper($('#imgEditBase')[0], {
                aspectRatio : NaN
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $('.btn-rotate').click(function(event) {
            cropper.rotate($(this).data('option'));
            event.preventDefault();
        });

        $('.btn-zoom').click(function(event) {
            cropper.zoom($(this).data('option'));
            event.preventDefault();
        });

        $('.btn-fliphor').click(function(event) {
            cropper.scaleX($(this).data('option'));
            if ($(this).data('option') == -1) {
                $(this).data('option',1);
            }else{
                $(this).data('option',-1);
            }
            event.preventDefault();
        });

        $('.btn-flipver').click(function(event) {
            cropper.scaleY($(this).data('option'));
            if ($(this).data('option') == -1) {
                $(this).data('option',1);
            }else{
                $(this).data('option',-1);
            }
            event.preventDefault();
        });

        $('.btn-cropper-reset').click(function(event) { 
            cropper.reset();
        });

        $('#saveCropped').click(function(event) {
            cropper.getCroppedCanvas().toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    //console.log(base64data);
                    showAjaxLoader();
                    $.post("<?= base_url('agent/change_cropped_image') ?>", 
                        {agent : $('input[name=agentId]').val(),type:$('input[name=typeOfPhoto]').val(),image:base64data}, 
                        function(result){
                            console.log(result);
                            hideAjaxLoader();
                            if(result._return){
                                window.location.reload();
                            }else{
                                PNOTY(result.msg,'error');    
                            }
                        }
                    );
                }
            });
        });
    });
</script>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalImageEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="cropper-img-container">
                            <img id="imgEditBase" src="" style="width:100%; border: solid 2px #ccc;">
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-mini btn-zoom" data-option="-0.1" title="Zoom Out">
                                        <i class="fa fa-search-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-mini btn-zoom" data-option="0.1" title="Zoom In">
                                      <i class="fa fa-search-plus"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-mini btn-rotate" data-option="-45" title="Rotate Left">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-mini btn-rotate" data-option="45" title="Rotate Right">
                                      <i class="fa fa-repeat"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-mini btn-fliphor" data-option="-1" title="Flip Horizontal">
                                        <i class="fa fa-arrows-h"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-mini btn-flipver" data-option="-1" title="Flip Vertical">
                                      <i class="fa fa-arrows-v"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-mini btn-cropper-reset" data-option="-1" title="Reset">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <h5>Preview</h5>
                        <div id="previewImage" style=""></div>
                    </div> -->
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="agentId" value="<?= $item->id ?>">
                <input type="hidden" name="typeOfPhoto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveCropped">Save Image</button>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    #previewImage{
        margin-bottom: 0.5rem;
        margin-right: 0.5rem;
        width: 160px;height: 160px; overflow: hidden; border: solid 2px #ccc;
    }
</style>
