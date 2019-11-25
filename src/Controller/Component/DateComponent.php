<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use RuntimeException;
use Cake\Filesystem\File;

/**
 * Date component
 */
class DateComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function initialize(array $config) {
        /*初期処理*/
    }

    /**
     * @param string $strDate 調べたい日にち（Y-m-d）
     *
     * @return integer $year 年度
     */    
    //年度の計算
    public function getFiscalYear($strDate = ''){
        $currentDate = new \DateTime($strDate);
        $currentDate->modify("-3 months");   
        
        return $currentDate->format('Y');
    }

        
    /**
     * @param date  $start 開始日（Y-m-d）
     * @param date  $end 終了日 (Y-m-d)
     * @param array $week 休日とカウントする曜日(date('w')の返り値の曜日idを配列で指定) デフォルトは土日
     * @param bool  $japaneseHolidayFlag 祝日をカウントするかどうか デフォルトはカウントする
     *
     * @return int|number
     */
    public function getHolidayCount($start, $end, $week = [],$given_holidays, $japaneseHolidayFlag = true) {
    
        $holidays = 0;
    
        // 指定曜日日数を算出
        $startTime = strtotime($start);
        $endTime = strtotime($end);
        $diffDays = 1 + ($endTime - $startTime) / 86400;
        $firstWeekday = date('w', $startTime);
        if (!empty($week)) {
            $holidays = $this->getWeekdays($diffDays,$week, $firstWeekday);
        }
        //debug($holidays);
        // 日本の祝日日数を算出
        if ($japaneseHolidayFlag) {
            $japaneseHolidays = $this->getHolidayList($start, $end, $week);
            if (!empty($japaneseHolidays)) {
                $holidays += count($japaneseHolidays);
            }
        }
        //debug($japaneseHolidays);
        //特定の休日を算出
        if (!empty($given_holidays)) {
            $holidays += $this->getGivenHolidays($start, $end, $week,$given_holidays);

        }    
        // debug($givenHolidays);
        return $holidays;
    }
    
    /**
     * 期間内で休日の曜日の日数を取得
     * 
     * @param integer  $diffDays   期間日数
     * @param array $week 休日の曜日配列
     * @param integer $firstWeekday 初日の曜日
     *
     * @return integer holidays
     */
    public function getWeekdays($diffDays,$week, $firstWeekday){
        $holidays = 0;
        for ($i=0; $i < $diffDays; $i++) { 
            if(\in_array($firstWeekday,$week)){
                $holidays += 1;
            }

            $firstWeekday += 1;
            if($firstWeekday > 6){
                $firstWeekday = 0;
            }

        }
        return $holidays;
    }



    /**
     * 特定の休日で期間内の日数を取得
     *
     * @param date  $start 開始日
     * @param date  $end   終了日
     * @param array $denyWeek 取得しない曜日（曜日日数で取得した曜日を指定すると重複を省ける）
     * @param array $given_holidays 特定の休日配列
     *
     * @return integer holidays
     */
    public function getGivenHolidays($start, $end, $denyWeek = array(),$given_holidays) {
    
        $holidays = 0;
        $startTime = strtotime($start);
        $endTime = strtotime($end);

        
        foreach ($given_holidays as $date ) {
            if(empty($date)){
                continue;
            }
            $thistime = strtotime($date);
            
            if (in_array(date('w', $thistime), $denyWeek)) {
                continue;
            }
            
            
            if($thistime >= $startTime and $thistime <= $endTime){
                $holidays += 1;
            }
            
        }
        return $holidays;
    }
    
    
     /**
     * 期間内の祝日を取得する 参考：https://humo-life.net/blog/php/727/
     *
     * @param       string      $date_start         開始日（Y-m-d）
     * @param       string      $date_end           終了日（Y-m-d）
     * @param       array       $denyWeek           取得しない曜日（曜日日数で取得した曜日を指定すると重複を省ける）
     * @return      array                           祝日の配列
     */
    public function getHolidayList($date_start, $date_end,$denyWeek) {

        $google_api_key = $this->_get_calendar_api();
        // debug($google_api_key);
        // カレンダーID
        $calendar_id = urlencode('ja.japanese#holiday@group.v.calendar.google.com');
    
        $max_results = 100;
    
        $startDate = new \DateTime($date_start);
        $endDate = new \DateTime($date_end);
    
        $param_start = $startDate->format('Y-m-d') . 'T00:00:00Z';
        $param_end = $endDate->format('Y-m-d') . 'T00:00:00Z';
    
        $url  = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events';
        $url .= '?key=' . $google_api_key;
        $url .= '&timeMin=' . $param_start;
        $url .= '&timeMax=' . $param_end;
        $url .= '&maxResults=' . $max_results;
        $url .= '&orderBy=startTime';
        $url .= '&singleEvents=true';
    
        $ref = 'https://holy-aobax.ssl-lolipop.jp/';
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_REFERER, $ref);
    
        $result = curl_exec($ch);
    
        curl_close($ch);
    
        if (empty($result) === true) {
            return array();
        }
    
        $json = json_decode($result);
    
        if (empty($json->items) === true) {
            return array();
        }
    
        $holiday_list = array();
    
        foreach ($json->items as $item ) {
            $date = $item->start->date;
            if (in_array(date('w', strtotime($date)), $denyWeek)) {
                continue;
            }
            // $title = (string) $item->summary;
            // $holiday_list[$date] = $title;
            $holiday_list[] = $date;
        }

        return $holiday_list;
    }
 
    // calenar API 用のAPI キーを読み込む
    protected function _get_calendar_api(){

        $file = new File(ROOT . DS . 'google_api.txt');
        $content = $file->read(); 
        return $content;     

    }
    
}
