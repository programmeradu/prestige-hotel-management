<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*/

if (!defined('_PS_VERSION_')) { exit; }
if (!class_exists('MCAPI', false)) {
    class MCAPI {
        var $version = "1.2";
        var $errorMessage;
        var $errorCode;

        var $apiUrl;
        var $timeout = 300;
        var $chunkSize = 8192;
        var $api_key;
        var $secure = false;
        public function __construct($apikey, $secure=false) {
            $this->secure = $secure;
            $this->apiUrl = parse_url("http://api.mailchimp.com/" . $this->version . "/?output=php");
            $this->api_key = $apikey;
        }
        public function setTimeout($seconds){
            if (is_int($seconds)){
                $this->timeout = $seconds;
                return true;
            }
        }
        public function getTimeout(){
            return $this->timeout;
        }
        public function useSecure($val){
            if ($val===true){
                $this->secure = true;
            } else {
                $this->secure = false;
            }
        }

        public function campaignUnschedule($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignUnschedule", $params);
        }


        public function campaignSchedule($cid, $schedule_time, $schedule_time_b=NULL) {
            $params = array();
            $params["cid"] = $cid;
            $params["schedule_time"] = $schedule_time;
            $params["schedule_time_b"] = $schedule_time_b;
            return $this->callServer("campaignSchedule", $params);
        }

        public function campaignResume($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignResume", $params);
        }

        public function campaignPause($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignPause", $params);
        }

        public function campaignSendNow($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignSendNow", $params);
        }

        public function campaignSendTest($cid, $test_emails=array (), $send_type=NULL) {
            $params = array();
            $params["cid"] = $cid;
            $params["test_emails"] = $test_emails;
            $params["send_type"] = $send_type;
            return $this->callServer("campaignSendTest", $params);
        }

        public function campaignTemplates() {
            $params = array();
            return $this->callServer("campaignTemplates", $params);
        }


        public function campaignSegmentTest($list_id, $options) {
            $params = array();
            $params["list_id"] = $list_id;
            $params["options"] = $options;
            return $this->callServer("campaignSegmentTest", $params);
        }
        public function campaignCreate($type, $options, $content, $segment_opts=NULL, $type_opts=NULL) {
            $params = array();
            $params["type"] = $type;
            $params["options"] = $options;
            $params["content"] = $content;
            $params["segment_opts"] = $segment_opts;
            $params["type_opts"] = $type_opts;
            return $this->callServer("campaignCreate", $params);
        }

        public function campaignUpdate($cid, $name, $value) {
            $params = array();
            $params["cid"] = $cid;
            $params["name"] = $name;
            $params["value"] = $value;
            return $this->callServer("campaignUpdate", $params);
        }

        public function campaignReplicate($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignReplicate", $params);
        }

        public function campaignDelete($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignDelete", $params);
        }

        public function campaigns($filters=array (), $start=0, $limit=25) {
            $params = array();
            $params["filters"] = $filters;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaigns", $params);
        }

        public function campaignFolders() {
            $params = array();
            return $this->callServer("campaignFolders", $params);
        }

        public function campaignStats($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignStats", $params);
        }

        public function campaignClickStats($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignClickStats", $params);
        }

        public function campaignEmailDomainPerformance($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignEmailDomainPerformance", $params);
        }

        public function campaignHardBounces($cid, $start=0, $limit=1000) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignHardBounces", $params);
        }

        public function campaignSoftBounces($cid, $start=0, $limit=1000) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignSoftBounces", $params);
        }

        public function campaignUnsubscribes($cid, $start=0, $limit=1000) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignUnsubscribes", $params);
        }

        public function campaignAbuseReports($cid, $since=NULL, $start=0, $limit=500) {
            $params = array();
            $params["cid"] = $cid;
            $params["since"] = $since;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignAbuseReports", $params);
        }

        public function campaignAdvice($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignAdvice", $params);
        }

        public function campaignAnalytics($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignAnalytics", $params);
        }

        public function campaignGeoOpens($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignGeoOpens", $params);
        }

        public function campaignGeoOpensForCountry($cid, $code) {
            $params = array();
            $params["cid"] = $cid;
            $params["code"] = $code;
            return $this->callServer("campaignGeoOpensForCountry", $params);
        }


        public function campaignEepUrlStats($cid) {
            $params = array();
            $params["cid"] = $cid;
            return $this->callServer("campaignEepUrlStats", $params);
        }


        public function campaignBounceMessages($cid, $start=0, $limit=25, $since=NULL) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            $params["since"] = $since;
            return $this->callServer("campaignBounceMessages", $params);
        }

        public function campaignEcommOrders($cid, $start=0, $limit=100, $since=NULL) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            $params["since"] = $since;
            return $this->callServer("campaignEcommOrders", $params);
        }


        public function campaignShareReport($cid, $opts=array ()) {
            $params = array();
            $params["cid"] = $cid;
            $params["opts"] = $opts;
            return $this->callServer("campaignShareReport", $params);
        }

        public function campaignContent($cid, $for_archive=true) {
            $params = array();
            $params["cid"] = $cid;
            $params["for_archive"] = $for_archive;
            return $this->callServer("campaignContent", $params);
        }


        public function campaignOpenedAIM($cid, $start=0, $limit=1000) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignOpenedAIM", $params);
        }

        public function campaignNotOpenedAIM($cid, $start=0, $limit=1000) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignNotOpenedAIM", $params);
        }

        public function campaignClickDetailAIM($cid, $url, $start=0, $limit=1000) {
            $params = array();
            $params["cid"] = $cid;
            $params["url"] = $url;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignClickDetailAIM", $params);
        }

        public function campaignEmailStatsAIM($cid, $email_address) {
            $params = array();
            $params["cid"] = $cid;
            $params["email_address"] = $email_address;
            return $this->callServer("campaignEmailStatsAIM", $params);
        }

        public function campaignEmailStatsAIMAll($cid, $start=0, $limit=100) {
            $params = array();
            $params["cid"] = $cid;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("campaignEmailStatsAIMAll", $params);
        }

        public function campaignEcommAddOrder($order) {
            $params = array();
            $params["order"] = $order;
            return $this->callServer("campaignEcommAddOrder", $params);
        }

        public function lists() {
            $params = array();
            return $this->callServer("lists", $params);
        }

        public function listMergeVars($id) {
            $params = array();
            $params["id"] = $id;
            return $this->callServer("listMergeVars", $params);
        }

        public function listMergeVarAdd($id, $tag, $name, $req=array (
    )) {
            $params = array();
            $params["id"] = $id;
            $params["tag"] = $tag;
            $params["name"] = $name;
            $params["req"] = $req;
            return $this->callServer("listMergeVarAdd", $params);
        }

        /**
         * Update most parameters for a merge tag on a given list. You cannot currently change the merge type
         *
         * @section List Related
         *
         * @param string $id the list id to connect to. Get by calling lists()
         * @param string $tag The merge tag to update
         * @param array $options The options to change for a merge var. See listMergeVarAdd() for valid options
         * @return bool true if the request succeeds, otherwise an error will be thrown
         */
        public function listMergeVarUpdate($id, $tag, $options) {
            $params = array();
            $params["id"] = $id;
            $params["tag"] = $tag;
            $params["options"] = $options;
            return $this->callServer("listMergeVarUpdate", $params);
        }

        public function listMergeVarDel($id, $tag) {
            $params = array();
            $params["id"] = $id;
            $params["tag"] = $tag;
            return $this->callServer("listMergeVarDel", $params);
        }

        public function listInterestGroups($id) {
            $params = array();
            $params["id"] = $id;
            return $this->callServer("listInterestGroups", $params);
        }

        public function listInterestGroupings($id) {
            $params = array();
            $params["id"] = $id;
            return $this->callServer("listInterestGroupings", $params);
        }

        public function listInterestGroupAdd($id, $group_name, $grouping_id=NULL) {
            $params = array();
            $params["id"] = $id;
            $params["group_name"] = $group_name;
            $params["grouping_id"] = $grouping_id;
            return $this->callServer("listInterestGroupAdd", $params);
        }

        public function listInterestGroupDel($id, $group_name, $grouping_id=NULL) {
            $params = array();
            $params["id"] = $id;
            $params["group_name"] = $group_name;
            $params["grouping_id"] = $grouping_id;
            return $this->callServer("listInterestGroupDel", $params);
        }

        public function listInterestGroupUpdate($id, $old_name, $new_name, $grouping_id=NULL) {
            $params = array();
            $params["id"] = $id;
            $params["old_name"] = $old_name;
            $params["new_name"] = $new_name;
            $params["grouping_id"] = $grouping_id;
            return $this->callServer("listInterestGroupUpdate", $params);
        }

        public function listInterestGroupingAdd($id, $name, $type, $groups) {
            $params = array();
            $params["id"] = $id;
            $params["name"] = $name;
            $params["type"] = $type;
            $params["groups"] = $groups;
            return $this->callServer("listInterestGroupingAdd", $params);
        }
        public function listInterestGroupingUpdate($grouping_id, $name, $value) {
            $params = array();
            $params["grouping_id"] = $grouping_id;
            $params["name"] = $name;
            $params["value"] = $value;
            return $this->callServer("listInterestGroupingUpdate", $params);
        }

        public function listInterestGroupingDel($grouping_id) {
            $params = array();
            $params["grouping_id"] = $grouping_id;
            return $this->callServer("listInterestGroupingDel", $params);
        }

        public function listWebhooks($id) {
            $params = array();
            $params["id"] = $id;
            return $this->callServer("listWebhooks", $params);
        }

        public function listWebhookAdd($id, $url, $actions=array (), $sources=array ()) {
            $params = array();
            $params["id"] = $id;
            $params["url"] = $url;
            $params["actions"] = $actions;
            $params["sources"] = $sources;
            return $this->callServer("listWebhookAdd", $params);
        }
        public function listWebhookDel($id, $url) {
            $params = array();
            $params["id"] = $id;
            $params["url"] = $url;
            return $this->callServer("listWebhookDel", $params);
        }

        public function listStaticSegments($id) {
            $params = array();
            $params["id"] = $id;
            return $this->callServer("listStaticSegments", $params);
        }

        public function listAddStaticSegment($id, $name) {
            $params = array();
            $params["id"] = $id;
            $params["name"] = $name;
            return $this->callServer("listAddStaticSegment", $params);
        }

        public function listResetStaticSegment($id, $seg_id) {
            $params = array();
            $params["id"] = $id;
            $params["seg_id"] = $seg_id;
            return $this->callServer("listResetStaticSegment", $params);
        }

        public function listDelStaticSegment($id, $seg_id) {
            $params = array();
            $params["id"] = $id;
            $params["seg_id"] = $seg_id;
            return $this->callServer("listDelStaticSegment", $params);
        }
        public function listStaticSegmentAddMembers($id, $seg_id, $batch) {
            $params = array();
            $params["id"] = $id;
            $params["seg_id"] = $seg_id;
            $params["batch"] = $batch;
            return $this->callServer("listStaticSegmentAddMembers", $params);
        }

        public function listStaticSegmentDelMembers($id, $seg_id, $batch) {
            $params = array();
            $params["id"] = $id;
            $params["seg_id"] = $seg_id;
            $params["batch"] = $batch;
            return $this->callServer("listStaticSegmentDelMembers", $params);
        }

        public function listSubscribe($id, $email_address, $merge_vars, $email_type='html', $double_optin=true, $update_existing=false, $replace_interests=true, $send_welcome=false) {
            $params = array();
            $params["id"] = $id;
            $params["email_address"] = $email_address;
            $params["merge_vars"] = $merge_vars;
            $params["email_type"] = $email_type;
            $params["double_optin"] = $double_optin;
            $params["update_existing"] = $update_existing;
            $params["replace_interests"] = $replace_interests;
            $params["send_welcome"] = $send_welcome;
            return $this->callServer("listSubscribe", $params);
        }

        public function listUnsubscribe($id, $email_address, $delete_member=false, $send_goodbye=true, $send_notify=true) {
            $params = array();
            $params["id"] = $id;
            $params["email_address"] = $email_address;
            $params["delete_member"] = $delete_member;
            $params["send_goodbye"] = $send_goodbye;
            $params["send_notify"] = $send_notify;
            return $this->callServer("listUnsubscribe", $params);
        }

        public function listUpdateMember($id, $email_address, $merge_vars, $email_type='', $replace_interests=true) {
            $params = array();
            $params["id"] = $id;
            $params["email_address"] = $email_address;
            $params["merge_vars"] = $merge_vars;
            $params["email_type"] = $email_type;
            $params["replace_interests"] = $replace_interests;
            return $this->callServer("listUpdateMember", $params);
        }

        public function listBatchSubscribe($id, $batch, $double_optin=true, $update_existing=false, $replace_interests=true) {
            $params = array();
            $params["id"] = $id;
            $params["batch"] = $batch;
            $params["double_optin"] = $double_optin;
            $params["update_existing"] = $update_existing;
            $params["replace_interests"] = $replace_interests;
            return $this->callServer("listBatchSubscribe", $params);
        }

        public function listBatchUnsubscribe($id, $emails, $delete_member=false, $send_goodbye=true, $send_notify=false) {
            $params = array();
            $params["id"] = $id;
            $params["emails"] = $emails;
            $params["delete_member"] = $delete_member;
            $params["send_goodbye"] = $send_goodbye;
            $params["send_notify"] = $send_notify;
            return $this->callServer("listBatchUnsubscribe", $params);
        }

        public function listMembers($id, $status='subscribed', $since=NULL, $start=0, $limit=100) {
            $params = array();
            $params["id"] = $id;
            $params["status"] = $status;
            $params["since"] = $since;
            $params["start"] = $start;
            $params["limit"] = $limit;
            return $this->callServer("listMembers", $params);
        }
        public function listMemberInfo($id, $email_address) {
            $params = array();
            $params["id"] = $id;
            $params["email_address"] = $email_address;
            return $this->callServer("listMemberInfo", $params);
        }

        public function listAbuseReports($id, $start=0, $limit=500, $since=NULL) {
            $params = array();
            $params["id"] = $id;
            $params["start"] = $start;
            $params["limit"] = $limit;
            $params["since"] = $since;
            return $this->callServer("listAbuseReports", $params);
        }

        public function listGrowthHistory($id) {
            $params = array();
            $params["id"] = $id;
            return $this->callServer("listGrowthHistory", $params);
        }

        public function getAffiliateInfo() {
            $params = array();
            return $this->callServer("getAffiliateInfo", $params);
        }
        public function getAccountDetails() {
            $params = array();
            return $this->callServer("getAccountDetails", $params);
        }

        public function generateText($type, $content) {
            $params = array();
            $params["type"] = $type;
            $params["content"] = $content;
            return $this->callServer("generateText", $params);
        }

        public function inlineCss($html, $strip_css=false) {
            $params = array();
            $params["html"] = $html;
            $params["strip_css"] = $strip_css;
            return $this->callServer("inlineCss", $params);
        }

        public function createFolder($name) {
            $params = array();
            $params["name"] = $name;
            return $this->callServer("createFolder", $params);
        }

        public function ecommAddOrder($order) {
            $params = array();
            $params["order"] = $order;
            return $this->callServer("ecommAddOrder", $params);
        }

        public function listsForEmail($email_address) {
            $params = array();
            $params["email_address"] = $email_address;
            return $this->callServer("listsForEmail", $params);
        }

        public function chimpChatter() {
            $params = array();
            return $this->callServer("chimpChatter", $params);
        }

        public function apikeys($username, $password, $expired=false) {
            $params = array();
            $params["username"] = $username;
            $params["password"] = $password;
            $params["expired"] = $expired;
            return $this->callServer("apikeys", $params);
        }

        public function apikeyAdd($username, $password) {
            $params = array();
            $params["username"] = $username;
            $params["password"] = $password;
            return $this->callServer("apikeyAdd", $params);
        }

        public function apikeyExpire($username, $password) {
            $params = array();
            $params["username"] = $username;
            $params["password"] = $password;
            return $this->callServer("apikeyExpire", $params);
        }

        public function ping() {
            $params = array();
            return $this->callServer("ping", $params);
        }

        public function callMethod() {
            $params = array();
            return $this->callServer("callMethod", $params);
        }

        public function callServer($method, $params) {
            $dc = "us1";
            if (strstr($this->api_key,"-")){
                list($key, $dc) = explode("-",$this->api_key,2);
                unset($key);
                if (!$dc) $dc = "us1";
            }
            $host = $dc.".".$this->apiUrl["host"];
            $params["apikey"] = $this->api_key;

            $this->errorMessage = "";
            $this->errorCode = "";
            $post_vars = $this->httpBuildQuery($params);

            $payload = "POST " . $this->apiUrl["path"] . "?" . $this->apiUrl["query"] . "&method=" . $method . " HTTP/1.0\r\n";
            $payload .= "Host: " . $host . "\r\n";
            $payload .= "User-Agent: MCAPI/" . $this->version ."\r\n";
            $payload .= "Content-type: application/x-www-form-urlencoded\r\n";
            $payload .= "Content-length: " . Tools::strlen($post_vars) . "\r\n";
            $payload .= "Connection: close \r\n\r\n";
            $payload .= $post_vars;

            ob_start();
            if ($this->secure){
                $sock = @fsockopen("ssl://".$host, 443, $errno, $errstr, 30);
            } else {
                $sock = @fsockopen($host, 80, $errno, $errstr, 30);
            }
            if(!$sock) {
                $this->errorMessage = "Could not connect (ERR $errno: $errstr)";
                $this->errorCode = "-99";
                ob_end_clean();
                return false;
            }

            $response = "";
            fwrite($sock, $payload);
            stream_set_timeout($sock, $this->timeout);
            $info = stream_get_meta_data($sock);
            while ((!feof($sock)) && (!$info["timed_out"])) {
                $response .= fread($sock, $this->chunkSize);
                $info = stream_get_meta_data($sock);
            }
            if ($info["timed_out"]) {
                $this->errorMessage = "Could not read response (timed out)";
                $this->errorCode = -98;
            }
            fclose($sock);
            ob_end_clean();
            if ($info["timed_out"]) return false;

            list($throw, $response) = explode("\r\n\r\n", $response, 2);
            unset($throw);
            if(ini_get("magic_quotes_runtime")) $response = stripslashes($response);

            $serial = @unserialize($response);
            if($response && $serial === false) {
                $response = array("error" => "Bad Response.  Got This: " . $response, "code" => "-99");
            } else {
                $response = $serial;
            }
            if(is_array($response) && isset($response["error"])) {
                $this->errorMessage = $response["error"];
                $this->errorCode = $response["code"];
                return false;
            }

            return $response;
        }

        public function httpBuildQuery($params, $key=null) {
            $ret = array();

            foreach((array) $params as $name => $val) {
                $name = urlencode($name);
                if($key !== null) {
                    $name = $key . "[" . $name . "]";
                }

                if(is_array($val) || is_object($val)) {
                    $ret[] = $this->httpBuildQuery($val, $name);
                } elseif($val !== null) {
                    $ret[] = $name . "=" . urlencode($val);
                }
            }

            return implode("&", $ret);
        }
    }
}
