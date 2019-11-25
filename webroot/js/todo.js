$(function () {

    'use strict';

    $("#myModalNorm input,#myModalNorm select").on('change',function(){

        formdata[$(this).attr('name')] = $(this).val();
    });

  });
const priorites = {'2':['優先度低','default'],'5':['優先度中','info'],'8':['優先度高','warning'],'10':['優先度緊急','danger']};  
// id bigint(20) AI PK 
// description 
// due_date 
// priority
// done
var formdata;
var list;

function fillForm(id){
    if(id != null){
        let item = getItem(id);
        
        formdata['id'] = item.id;
        formdata['description'] = item.description;
        formdata['due_date'] = (item.due_date == null)? null:moment(item.due_date).format('YYYY/MM/DD');
        formdata['priority'] = item.priority;
        formdata['done'] = (item.done == false)? 0:1;

    }


    set_form_fields();
}
function getItem(id){
    for(const item of list){
        if(item.id == id){
            return item;
        }
    }

}

function set_form_fields(){
    Object.keys(formdata).forEach(function(key){
        $("[name=" + key + "]").val(formdata[key]);
    });
}

function resetForm(mode){
    formdata = {
        'mode':mode,
        'id':null,
        'description':'',
        'due_date':'',
        'priority':5,
        'done':0
    };
}

function toggleItemToDone(id){
    var item = getItem(id);

    var checkbox = $("#check" + id);
    var is_checked = checkbox.prop('checked');
    if(is_checked){    
        item.done = 1;
    }else{
        item.done = 0;     
    }
    let saveData = {
        id:id,
        done:item.done
    };
    submitData(saveData);

}

function createPostData(data){
   
    if(data['description'] == ''){
        return false;
    }

    return data;
}

function submitForm(){

    data = createPostData(formdata);
    if(data == false){
        alert('リスト項目の内容を入力してください。');
        return false;
    } 

    submitData(data);
}

function submitData(data){
    var Url = "/aoba_business_system/TodoLists/ajaxsavelistitem";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:data,
        type:"POST",
        headers: { 'X-CSRF-Token': csrf },
        success:function(data){
            // カンマ区切りテキストを解析して一致したデータを表示
            var parseData = eval("("+data+")");  
            //         alert(parseData);   
            list = parseData.list;
            dispList(parseData.list);
            dispSaveResult(parseData.response);

            $('#myModalNorm').modal('hide');
        
        },
        error:function(XHR, status, errorThrown){
            alert(status);
        }
        
        });
}

function loadList(){

    var Url = "/aoba_business_system/TodoLists/ajaxloadlist";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
    url:Url,
    // data:data,
    type:"GET",
    headers: { 'X-CSRF-Token': csrf },
    success:function(data){
        // カンマ区切りテキストを解析して一致したデータを表示
        var parseData = eval("("+data+")");  
        //         alert(parseData);   
        list = parseData;
        dispList(parseData);
    
    
    },
    error:function(XHR, status, errorThrown){
        alert(status);
    }
    
    });
        
}

function deletelistitem(id){

    if(!confirm('本当に削除しますか?')){
        return;
    }


    var Url = "/aoba_business_system/TodoLists/ajaxdeletelistitem";
    //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    $.ajax({
        url:Url,
        data:{id:id},
        type:"DELETE",
        headers: { 'X-CSRF-Token': csrf },
        success:function(data){
            // カンマ区切りテキストを解析して一致したデータを表示
            var parseData = eval("("+data+")");  
            //         alert(parseData);   
            list = parseData.list;
            dispList(parseData.list);
            dispSaveResult(parseData.response);       
        
        },
        error:function(XHR, status, errorThrown){
            alert(status);
        }
        
        });

}


function dispList(list){

    var str_li = "";
    for(const item of list){
        if(item.due_date != null && item.due_date != ''){
            var due_date = '（'+ moment(item.due_date).format('YYYY-MM-DD') +'まで）';

        }else{
            var due_date = '';
        }
        if(item.done == 1){
            var content = '<del>' + item.description + due_date + '</del>';
            var label = '';
            var checked = "checked";
        }else{
            var content = item.description + due_date;
            var label = '<small class="label label-'+ priorites[item.priority][1] +'">'+ priorites[item.priority][0] +'</small>';
            var checked = "";
        }
        str_li += '<li>'+
        '<input id="check'+item.id+'" type="checkbox" ' + checked + ' onclick="Javascript:toggleItemToDone('+ item.id +')">'+
       '<span class="text">' + content + '</span>'+
       label +
       '<div class="tools">'+
           '<i class="fa fa-edit"  data-toggle="modal" data-target="#myModalNorm" onclick="Javascript:resetForm(\'edit\');fillForm('+ item.id +');"></i>'+
           '<i class="fa fa-trash-o" onclick="Javascript:deletelistitem('+ item.id +');"></i>'+
       '</div>'+
       '</li>';

    }
    $(".todo-list").html(str_li);


}

function dispSaveResult(response){

    if(response.result == 1){
        $("#modal-alert").modal('show').removeClass("modal-danger").addClass("modal-success");
        $("#modal-title").text("保存成功");
        $("#modal-message").text(response.message);         

    }else{
        $("#modal-alert").modal('show').removeClass("modal-success").addClass("modal-danger");           
        $("#modal-title").text("保存失敗");
        $("#modal-message").text(response.message);
    }


}