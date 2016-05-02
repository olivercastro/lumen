@extends('layout.master')
@section('body')
    <form action="<?php echo $postpath; ?>" method="post" id="frm-comment" data-captcha="http://dev.training.lumen.loc/generate">
        <div class="form-group">
            <label for="fn">First Name</label>
            <input type="text" name="fn" class="form-control required"/>
        </div>
        <div class="form-group">
            <label for="ln">Last Name</label>
            <input type="text" name="ln" class="form-control required"/>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control required email"/>
        </div>
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment" id="" cols="30" rows="10" class="form-control required"></textarea>
        </div>
        <div class="form-group ">
            <label for="captcha">Captcha</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span id="op1"><?php echo $data->op1; ?></span>
                    <span id="opr"><?php echo $data->opr; ?></span>
                    <span id="op2"><?php echo $data->op2; ?></span>
                </span>
                <input type="text" name="captcha" class="form-control"/>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Post</button>
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#frm-comment").submit(function(evt){
                var elements = $("#frm-comment :input");
                if(hasRequiredFields(elements) && checkEmail(elements)){
                    console.log("submit");
                }else{
                    console.log("Correct");
                }
                checkCaptCha($("#frm-comment").data("captcha"));
                evt.preventDefault();
                function hasRequiredFields(els){
                    var flag =true;
                    $.each(els, function(ndx, el){
                        $(el).next().remove();
                        if($(el).hasClass('required')){
                            if($(el).val() == ""){
                                var errEl = '<span class="alert alert-danger">*Required field</span>';
                                $(el).after(errEl);
                                flag = false;
                            }
                        }
                    }.bind(flag));
                    return flag;
                }
                function checkEmail(els){
                    var flag = true;
                    $.each(els,function(ndx, el){
                        if($(el).val() != ""){
                            $(el).next().remove();
                        }
                        if($(el).val() != "" && $(el).hasClass("email")){

                            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                            var errEl = '<span class="alert alert-danger">Invalid E-mail</span>';
                            flag = regex.test($(el).val());
                            if(!flag){
                                $(el).after(errEl);
                            }
                        }
                    }.bind(flag));
                    return flag;
                }
                function checkCaptCha(path){
                    console.log(path);
                    var captChaEl = $("#frm-comment :input[name='captcha']");
                    $.ajax({
                        'url': path,
                        'method' : 'post',
                        'data' : {ans: $(captChaEl).val()},
                        'success' : function(response){
                            alert("done");
                        }
                    })

                }
            });

        });
    </script>
@endsection