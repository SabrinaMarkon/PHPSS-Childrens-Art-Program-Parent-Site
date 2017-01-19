<?php
if (isset($showupdate))
{
    echo $showupdate;
}
$allpages = new Page();
$pages = $allpages->getAllPages();
?>

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="/../js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
    tinymce.init({
        selector: 'textarea',  // change this value according to your HTML
        body_id: 'elm1=htmlcode',
        height: 400,
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
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
</script>
<!-- /tinyMCE -->

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h1 class="ja-bottompadding">Webpage Content</h1>

            <form action="/admin/pages" method="post" accept-charset="utf-8" class="form" role="form">
                <div class="form-group textfield">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label for="id">Edit Page:</label></div>
                        <div class="col-sm-6">
                            <select name="id" class="form-control">
                                <option value="" disabled selected>Select page to edit</option>
                                <?php
                                foreach($pages as $page)
                                if ($id !== '') {
                                    echo "<option value='" . $id . "' selected>" . $page['name'] . "</option>";
                                } else {
                                    echo "<option value='" . $id . "'>" . $page['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="hidden" name="_method" value="POST">
                            <button class="btn btn-md btn-primary pull-left" type="submit" name="editpage">EDIT</button></div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </form>

            <?php
            if (isset($showeditpage) && $showeditpage !== '') {

                // EDIT EXISTING PAGE:
                ?>
                <form action="/admin/pages/<?php echo $showeditpage['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <label class="sr-only" for="name">Page Name</label>
                            <input type="text" name="name" placeholder="Page Name" class="form-control" value="<?php echo $showeditpage['name']; ?>">
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <label class="sr-only" for="htmlcode">Page HTML</label>
                            <textarea name="htmlcode" placeholder="Page HTML" class="form-control" rows="30"><?php echo $showeditpage['htmlcode']; ?></textarea>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">

                        <div class="col-sm-2"></div>
                        <div class="col-sm-2">
                            <input type="hidden" name="_method" value="GET">
                            <button class="btn btn-md btn-primary" type="button" name="showallpages" onclick="parent.location = '/admin/pages'">RETURN</button>
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="_method" value="PATCH">
                            <button class="btn btn-md btn-primary" type="submit" name="savepage">SAVE</button>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <form action="/admin/pages/<?php echo $showeditpage['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-md btn-primary" type="submit" name="deletepage">DELETE</button>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>

                    </div>
                </div>
                <?php

            } else {

                // CREATE NEW PAGE:
                ?>
                <form action="/admin/pages" method="post" accept-charset="utf-8" class="form" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <label class="sr-only" for="name">Page Name</label>
                                <input type="text" name="name" placeholder="Page Name" class="form-control">
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <label class="sr-only" for="htmlcode">Page HTML</label>
                                <textarea name="htmlcode" placeholder="Page HTML" class="form-control" rows="30"></textarea>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <input type="hidden" name="_method" value="POST">
                                <button class="btn btn-lg btn-primary" type="submit" name="addpage">ADD</button>
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