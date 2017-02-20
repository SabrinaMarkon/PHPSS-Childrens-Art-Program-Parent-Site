<?php
if (isset($showupdate))
{
    echo $showupdate;
}
$allproducts = new Product();
$products = $allproducts->getAllProducts();
?>

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="/../js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
    tinymce.init({
        setup : function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '22px';
                this.getDoc().body.style.fontFamily = 'Calibri';
                this.getDoc().body.style.backgroundColor = '#ffffff';
            });
        },
        selector: 'textarea',  // change this value according to your HTML
        body_id: 'elm1=message',
        height: 600,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
//            '/../css/bootstrap.min.css',
//            '/../css/bootstrap-theme.min.css',
//            '/../css/custom.css'
        ]
    });
</script>
<!-- /tinyMCE -->

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h1 class="ja-bottompadding2">Sell Products and Services</h1>

            <form action="/admin/products" method="post" accept-charset="utf-8" class="form ja-bottompadding2" role="form">
                <div class="form-group textfield">
                    <div class="row">
                        <div class="col-sm-3">Edit Product:</div>
                        <div class="col-sm-6">
                            <select name="id" class="form-control">
                                <option value="" disabled selected>Select product to edit</option>
                                <?php
                                foreach($products as $product)
                                    if (isset($showeditproduct) && $showeditproduct !== '') {
                                        if ($product['id'] === $showeditproduct['id']) {
                                            echo "<option value='" . $product['id'] . "' selected>" . $product['name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $product['id'] . "'>" . $product['name'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value='" . $product['id'] . "'>" . $product['name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="_method" value="POST">
                            <button class="btn btn-md btn-primary pull-left" type="submit" name="editproduct" style="margin-right:10px;">EDIT</button>
                            <?php
                            if (isset($showeditproduct) && $showeditproduct !== '') {
                                ?>
                                <button class="btn btn-md btn-primary pull-left" type="button" name="showallproducts"
                                        onclick="parent.location = '/admin/products'">RETURN
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </form>

            <?php
            if (isset($showeditproduct) && $showeditproduct !== '') {
                // EDIT PRODUCT FORM
                ?>
            <form action="/admin/products/<?php echo $showeditproduct['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3 text-right">Product Name:</div>
                        <div class="col-sm-6"><input type="text" name="name" placeholder="Name your product" class="form-control" value="<?php echo $showeditproduct['name']; ?>"></div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3 text-right">Quantity:</div>
                        <div class="col-sm-6">
                            <select name="quantity" class="form-control">
                                <?php
                                for ($i = 1; $i <= 100; $i++) {
                                ?>
                                <option value="<?php echo $i ?>" <?php if ($i == $showeditproduct['quantity']) { echo ' selected'; } ?>><?php echo $i ?></option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3 text-right">Price:</div>
                        <div class="col-sm-6">
                            <input type="number" name="price" placeholder="0.01" class="form-control" step="0.01" min="0.01" value="<?php echo $showeditproduct['price']; ?>">
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3 text-right">Commission:</div>
                        <div class="col-sm-6">
                            <input type="number" name="commission" placeholder="0.00" class="form-control" step="0.01" min="0.00" value="<?php echo $showeditproduct['commission']; ?>">
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10 text-left"><br>Product Description:</div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <textarea name="description" id="description" placeholder="Product Description" class="form-control" rows="30" cols="65"><?php echo $showeditproduct['description']; ?></textarea>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2">
                            <button class="btn btn-lg btn-primary" type="button" name="showallproducts" onclick="parent.location = '/admin/products'">CREATE NEW</button>
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="_method" value="PATCH">
                            <button class="btn btn-lg btn-primary" type="submit" name="saveproduct">SAVE</button>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <form action="/admin/products/<?php echo $showeditproduct['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                                <input type="hidden" name="name" value="<?php echo $showeditproduct['name']; ?>">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-lg btn-primary" type="submit" name="deleteproduct">DELETE</button>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
            <?php
            } else {
                // CREATE NEW PRODUCT FORM
                ?>
                <form action="/admin/products" method="post" accept-charset="utf-8" class="form" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 text-right">Product Name:</div>
                            <div class="col-sm-6"><input type="text" name="name" placeholder="Name your product" class="form-control"></div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 text-right">Quantity:</div>
                            <div class="col-sm-6">
                                <select name="quantity" class="form-control">
                                    <?php
                                    for ($i = 1; $i <= 100; $i++) {
                                        ?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 text-right">Price:</div>
                            <div class="col-sm-6">
                                <input type="number" name="price" placeholder="0.01" class="form-control" step="0.01" min="0.01">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 text-right">Commission:</div>
                            <div class="col-sm-6">
                                <input type="number" name="commission" placeholder="0.00" class="form-control" step="0.01" min="0.00">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10 text-left"><br>Product Description:</div>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <textarea name="description" id="description" placeholder="Product Description" class="form-control"  rows="30" cols="65"></textarea>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <input type="hidden" name="_method" value="POST">
                                <button class="btn btn-lg btn-primary" type="submit" name="addproduct">ADD PRODUCT</button>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                </form>
                <?php
            }
            ?>

            <div class="ja-bottompadding"></div>

        </div>
    </div>
</div>