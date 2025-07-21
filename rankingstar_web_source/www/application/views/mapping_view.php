<!-- CONTESTANT MODAL -->
<div class="modal fade" id="exampleModalLabel" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang("CONTESTANT_MAPPING") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo BASE_URL . "contest/addtomapping"; ?>" method="post" id="mappingForm">
                <div class="modal-body">
                    <table id="contestantlist" class="table table-bordered table-striped">
                        <input type="hidden" id="contestId" name="contestId" value="">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll" class="form-check-input checkboxspace checkboxheading"></th>
                                <th><?php echo lang("CONTESTANT_NAME") ?></th>
                                <th><?php echo lang("LBL_CATEGORY_NAME") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listofcontestant as $list) {?>
                            <tr>
                                <td><input type="checkbox" id="ContastantId" class="form-check-input checkboxspace contestCheckbox" name="contestantId[]"  value="<?php echo $list['contestant_id'] ?>" <?php if (in_array($list['contestant_id'], $mappingContesantId)) {echo 'checked="checked"';}?>></td>
                                <td><label class="form-check-label" for="exampleCheck1"><?php echo $list['name'] ?></label></td>
                              
                                <td>
                                <?php if(!empty($categoryData)){ ?>
                                    <select class="form-control select2 categoryDropdown" name="contest_category_id[]" id="dd_category_<?php echo $list['contestant_id']; ?>"  style="width: 100%;" <?php if (!in_array($list['contestant_id'], $mappingContesantId)) {echo 'disabled="disabled"';}?> >
                                    <option value=""><?php echo lang("LBL_SELECT_CATEGORY") ?></option>
                                    <?php foreach($categoryData as $category) {                                     
                                        if(array_key_exists($list['contestant_id'], $mappingCategoryId) && $category['contest_category_id'] === $mappingCategoryId[$list['contestant_id']]) { ?>
                                            <option value="<?php echo $category['contest_category_id']?>" selected><?php echo $category['category_name'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $category['contest_category_id']?>"><?php echo $category['category_name'] ?></option>
                                        <?php } ?> 
                                    <?php } ?>  
                                    </select> 
                                    <?php } ?>
                                </td>
                                       
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal"><?php echo lang("CLOSE") ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("SUBMIT") ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- CONTESTANT MODEL -->
<script type="text/javascript">
function openOption(){  
    if ($(this).is(":checked")) { 
                var contestant_id = $(this).val();
                $("#dd_category_"+contestant_id).prop("disabled", false);
        //         if($("#dd_category_"+contestant_id).length){
        //             var a =  $("#dd_category_"+contestant_id).val();
        //             if(a.length == 0){
        //                 alert("select caltegory");
        //             }
        // }
            } else {
                var contestant_id = $(this).val();
                $("#dd_category_"+contestant_id).prop("disabled", true);  
               
                
            }
}
    $(document).ready(function() {
        //     var checked = $("#ContastantId input:checked").length > 0;
        //     if (!checked){
        //     alert("Please check at least one checkbox");
        //     return false;
        // }
        $('#contestantlist').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "order": [
                [1, 'asc']
            ],
            "columns": [{
                "orderable": false
                },
                null,
                null,
            ],
            "info": false,
            "autoWidth": false,
            "processing": true,
        });
        $(".contestCheckbox").click(openOption);
        $("#selectAll").change(function(){
            if ($(this).is(":checked")) { 
                $(".categoryDropdown").prop("disabled", false);
            } else {
                $(".categoryDropdown").prop("disabled", true);  
            }
        });
    });
    $("#mappingForm").on("submit", function(){
        var count = 0;
        var category = [];
        $('.contestCheckbox:checked').each(function() {
            if ($(this).is(":checked")) { 
                var contestant_id = $(this).val();
                var a =  $("#dd_category_"+contestant_id).val();
                category.push(a);
                count++;
            } 
        });
        var newArray = category.filter(function(v){return v!==''}).length;
        if(count == newArray){
            return true;
        }
        else{
            alert('<?php echo lang("LBL_SELECT_CATEGORY") ?>');
            return false;
        }
        
        
       
 });
</script>