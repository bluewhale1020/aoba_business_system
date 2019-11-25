$(function () {

    'use strict';
   // ロケールを設定
   moment.locale('ja');

   setTimeout(loadnotifications,3000);
    
});

function loadnotifications(){

    // var data = {};
    
    var Url = "/aoba_business_system/Utilities/ajaxloadnotifications";
    //urlはプロジェクト名/コントローラー名/アクション名小文字
    $.ajax({
        url:Url,
        // data:data,
        type:"GET",
        // headers: { 'X-CSRF-Token': csrf },
        success:function(data){
            // カンマ区切りテキストを解析して一致したデータを表示
            var parseData = eval("("+data+")");  
            
            //取得データをお知らせリストに表示
            disp_notifications(parseData);
        
        },
        error:function(XHR, status, errorThrown){
            alert(status);
        }
        
        });

}

//  parseData = [
//   totalcount : $totalcount,
//   unconfirmed_orders : $unconfirmed_orders,
//   unfinished_works : $unfinished_works,
//   unbilled_orders : $unbilled_orders,
//   unpaid_bills : $unpaid_bills
// ] 

function disp_notifications(data){
    // ラベルに総件数を表示
    $("#notice_count").text(data.totalcount);

    // リストに内容ごとに分けて表示する

    // 間近の未確定注文
    let order_list = create_list_items(data.unconfirmed_orders,'order');
    add_li_items('unconfirmed_order_list',order_list);
    
    // 期間終了未完了作業
    let work_list = create_list_items(data.unfinished_works,'work');
    add_li_items('unfinished_work_list',work_list);
    
    // 完了未請求注文
    let unbilled_list = create_list_items(data.unbilled_orders,'unbilled');
    add_li_items('unbilled_order_list',unbilled_list);

    // 締切後未回収請求
    let bill_list = create_list_items(data.unpaid_bills,'bill');
    add_li_items('unpaid_bill_list',bill_list);
}

function add_li_items(prev_id,li_items){
    $("#" + prev_id).after(li_items);
}

function create_list_items(category_data,type){
    lists = "";
    for(const record of category_data){
        let url = create_url(record,type);
        let text = create_text(record,type);
        let li_item = get_list_item(url,text);
        lists += li_item;
    }

    return lists;
}

function get_list_item(url,text){
    return '<li><a href="' + url + '" target="_blank">' + text + '</a></li>'; 
}

function create_text(record,type){
    switch (type) {
        case 'order':// 注文番号【開始日～】(元)請負元名
            return record.order_no + "【" + date_format(record.start_date) + "～】" + "(元)" + record.client.name;
            break;
        case 'work':// 注文番号【～終了日】(派)派遣先名
            return record.order_no + "【～" + date_format(record.end_date) + "】" + "(派)" + record.work_place.name;
            break;
        case 'unbilled':// 注文番号【～終了日】(請)請求先名
            return record.order_no + "【～" + date_format(record.end_date) + "】" + "(請)" + record.payer.name;
            break;
        case 'bill':// 請求書番号【送 送付日】請求先名
            return record.bill_no + "【送 " + date_format(record.bill_sent_date) + "】" + record.business_partner.name;
            break;
    
        default:
            break;
    }   
}

function create_url(record,type){
    var yearmonth;
    switch (type) {
        case 'order':
            return "/aoba_business_system/Orders/view/" + record.id;
            break;
        case 'work':
            return "/aoba_business_system/Works/view/" + record.works[0].id;
            break;
        case 'unbilled':
            yearmonth = get_year_month_for_record(record.end_date);
            // view($id = null,$year = null, $month = null)
            return "/aoba_business_system/Bills/index/" + record.payer_id + "/" + yearmonth.year+ "/" + yearmonth.month;    
            break;
        case 'bill':
            yearmonth = get_year_month_for_record(record.bill_sent_date);
            // indexAll/0/2019/11/未回収
            return "/aoba_business_system/Bills/indexAll/" + record.business_partner_id + "/" + yearmonth.year+ "/" + yearmonth.month + "/未回収";
            break;
    
        default:
            return "#";
            break;
    }


}

function date_format(date_obj){
    var m = moment(date_obj);
    return m.format("YYYY-MM-DD");     
}

function get_year_month_for_record(date_obj){
    var m = moment(date_obj); // 第一引数：指定日時、第二引数：フォーマット
    return {year:m.year(),month:m.month() + 1};
}