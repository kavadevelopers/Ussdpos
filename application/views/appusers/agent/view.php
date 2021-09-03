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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#doc" role="tab" aria-selected="false">Documents</a>
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
                                                        <table class="table m-0 tbl-shopdis">
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
                                                                        <a href="https://web.whatsapp.com/send?phone=+234<?= $item->phone ?>">
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
                <div class="tab-pane" id="doc" role="tabpanel">
                    <div class="card">
                        <div class="card-block">
                            <div class="view-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table m-0 tbl-shopdis">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">ID Verification</th>
                                                                    <td>
                                                                        <a href="#" class="photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileid) ?>">
                                                                            <img src="<?= $item->detail->fileid ?>" style="max-width: 200px;">
                                                                        </a>
                                                                    </td>
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
                                                                    <th scope="row">Address Verification</th>
                                                                    <td>
                                                                        <a href="#" class="photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($item->detail->fileaddress) ?>">
                                                                            <img src="<?= $item->detail->fileaddress ?>" style="max-width: 200px;">
                                                                        </a>
                                                                    </td>
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
            </div>
        </div>
    </div>

</div>

<style type="text/css">
    .tbl-shopdis td{
        white-space: normal;
    }
</style>