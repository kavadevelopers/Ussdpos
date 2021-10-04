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
                 <a href="<?= base_url('products/add') ?>" class="btn btn-primary btn-mini"><i class="fa fa-plus"></i> Add</a>  
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block table-responsive">
                    <table class="table table-bordered table-mini table-striped table-dt">
                        <thead>
                            <tr>
                                <th class="text-center">Thumbnail</th>
                                <th class="text-center">Charge Info</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th class="text-right">Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $key => $value) { ?>
                                <?php $category = $this->db->get_where('products_cate',['id' => $value->category])->row_object() ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="#" class="photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($this->general_model->getProductThumb($value->id)) ?>">
                                            <img src="<?= $this->general_model->getProductThumb($value->id)?>" style="max-width: 80px;">
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="photo-swipe" data-photoswipe="<?= $this->general_model->imagesArrayForPhotoSwipe($this->general_model->getProductInfo($value->id)) ?>">
                                            <img src="<?= $this->general_model->getProductInfo($value->id)?>" style="max-width: 80px;">
                                        </a>
                                    </td>
                                    <td><?= $value->name ?></td>
                                    <td><?= $category->name ?></td>
                                    <td class="text-right"><?= niara().$value->price ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('products/edit/').$value->id ?>" class="btn btn-primary btn-mini">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('products/delete/').$value->id ?>/transfer" class="btn btn-danger btn-mini btn-delete">
                                            <i class="fa fa-trash"></i>
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