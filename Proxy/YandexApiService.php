<?php

namespace Biplane\YandexDirectBundle\Proxy;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Biplane\YandexDirectBundle\Contract;
use Biplane\YandexDirectBundle\Events;
use Biplane\YandexDirectBundle\Event\PreCallEvent;
use Biplane\YandexDirectBundle\Event\PostCallEvent;
use Biplane\YandexDirectBundle\Event\FailCallEvent;

/**
 * @version v4.live
 *
 * @codeCoverageIgnore
 */
class YandexApiService
{
    private $dispatcher;
    private $client;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher  The event dispatcher
     * @param Client\ClientInterface   $client      A ClientInterface implementation
     */
    public function __construct(EventDispatcherInterface $dispatcher, Client\ClientInterface $client)
    {
        $this->client = $client;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Gets a content of last request.
     *
     * @return string
     */
    public function getLastRequest()
    {
        return $this->client->getLastRequest();
    }

    /**
     * Gets a content of last response.
     *
     * @return string
     */
    public function getLastResponse()
    {
        return $this->client->getLastResponse();
    }

    /**
     * Gets the number of the latest API version.
     *
     * @return int The number of the last API version
     */
    public function getVersion()
    {
        return $this->invoke('GetVersion', array());
    }

    /**
     * Gets the personal information of all users, or of those that meet the filtering conditions.
     *
     * @param Contract\ClientInfoRequest $ClientInfoRequest
     *
     * @return Contract\ClientInfo[]
     */
    public function getClientsList(Contract\ClientInfoRequest $ClientInfoRequest)
    {
        return $this->invoke('GetClientsList', array($ClientInfoRequest));
    }

    /**
     * Gets a list of users associated with the specified user or agency.
     *
     * @param Contract\GetSubClientsRequest $GetSubClientsRequest
     *
     * @return Contract\ShortClientInfo[]
     */
    public function getSubClients(Contract\GetSubClientsRequest $GetSubClientsRequest)
    {
        return $this->invoke('GetSubClients', array($GetSubClientsRequest));
    }

    /**
     * Sets the CPC for all phrases in the campaign, or only for those phrases that meet the filter conditions.
     *
     * @param Contract\AutoPriceInfo $AutoPriceInfo
     *
     * @return Contract\PhrasePriceInfo[]
     */
    public function setAutoPrice(Contract\AutoPriceInfo $AutoPriceInfo)
    {
        return $this->invoke('SetAutoPrice', array($AutoPriceInfo));
    }

    /**
     * Deletes a campaign statistics report from the server.
     *
     * @param int $id The ID of the report to delete
     *
     * @return int 1 when the report is deleted successfully
     */
    public function deleteReport($id)
    {
        return $this->invoke('DeleteReport', array($id));
    }

    /**
     * Gets statistics for each day of the specified period for the specified campaign.
     *
     * @param Contract\GetSummaryStatRequest $GetSummaryStatRequest
     *
     * @return Contract\StatItem[]
     */
    public function getSummaryStat(Contract\GetSummaryStatRequest $GetSummaryStatRequest)
    {
        return $this->invoke('GetSummaryStat', array($GetSummaryStatRequest));
    }

    /**
     * Gets the campaign parameters.
     *
     * @param Contract\CampaignIDInfo $CampaignIDInfo
     *
     * @return Contract\CampaignInfo
     *
     * @deprecated
     */
    public function getCampaignParams(Contract\CampaignIDInfo $CampaignIDInfo)
    {
        return $this->invoke('GetCampaignParams', array($CampaignIDInfo));
    }

    /**
     * Gets the parameters of one or more campaigns.
     *
     * @param Contract\CampaignIDSInfo $CampaignIDSInfo
     *
     * @return Contract\CampaignInfo[]
     */
    public function getCampaignsParams(Contract\CampaignIDSInfo $CampaignIDSInfo)
    {
        return $this->invoke('GetCampaignsParams', array($CampaignIDSInfo));
    }

    /**
     * Deletes a report on the server about the projected number of impressions, clicks and campaign spending.
     *
     * @param int $id The ID of the report to delete
     *
     * @return int If deletion was successful, the value 1 is returned
     */
    public function deleteForecastReport($id)
    {
        return $this->invoke('DeleteForecastReport', array($id));
    }

    /**
     * Submits an ad with "Draft" status for moderation.
     *
     * @param Contract\CampaignBidsInfo $CampaignBidsInfo
     *
     * @return int 1 when executed successfully
     */
    public function moderateBanners(Contract\CampaignBidsInfo $CampaignBidsInfo)
    {
        return $this->invoke('ModerateBanners', array($CampaignBidsInfo));
    }

    /**
     * Stops displaying ads.
     *
     * @param Contract\CampaignBidsInfo $CampaignBidsInfo
     *
     * @return int 1 when executed successfully
     */
    public function stopBanners(Contract\CampaignBidsInfo $CampaignBidsInfo)
    {
        return $this->invoke('StopBanners', array($CampaignBidsInfo));
    }

    /**
     * Allows ad displays.
     *
     * @param Contract\CampaignBidsInfo $CampaignBidsInfo
     *
     * @return int 1 when executed successfully
     */
    public function resumeBanners(Contract\CampaignBidsInfo $CampaignBidsInfo)
    {
        return $this->invoke('ResumeBanners', array($CampaignBidsInfo));
    }

    /**
     * Archives the ad.
     *
     * @param Contract\CampaignBidsInfo $CampaignBidsInfo
     *
     * @return int 1 when executed successfully
     */
    public function archiveBanners(Contract\CampaignBidsInfo $CampaignBidsInfo)
    {
        return $this->invoke('ArchiveBanners', array($CampaignBidsInfo));
    }

    /**
     * Removes an ad from the archive.
     *
     * @param Contract\CampaignBidsInfo $CampaignBidsInfo
     *
     * @returns int 1 when executed successfully
     */
    public function unArchiveBanners(Contract\CampaignBidsInfo $CampaignBidsInfo)
    {
        return $this->invoke('UnArchiveBanners', array($CampaignBidsInfo));
    }

    /**
     * Deletes the ad.
     *
     * You can only delete an ad that has not been displayed and does not have any statistics yet.
     * For other ads, archiving is available using the {@see archiveBanners} method.
     *
     * @param Contract\CampaignBidsInfo $CampaignBidsInfo
     *
     * @return int 1 when deleted successfully
     */
    public function deleteBanners(Contract\CampaignBidsInfo $CampaignBidsInfo)
    {
        return $this->invoke('DeleteBanners', array($CampaignBidsInfo));
    }

    /**
     * Stops displaying the ads in the campaign.
     *
     * @param Contract\CampaignIDInfo $CampaignIDInfo
     *
     * @return int 1 when executed successfully
     */
    public function stopCampaign(Contract\CampaignIDInfo $CampaignIDInfo)
    {
        return $this->invoke('StopCampaign', array($CampaignIDInfo));
    }

    /**
     * Deletes the campaign.
     *
     * @param Contract\CampaignIDInfo $CampaignIDInfo
     *
     * @return int 1 when executed successfully
     */
    public function deleteCampaign(Contract\CampaignIDInfo $CampaignIDInfo)
    {
        return $this->invoke('DeleteCampaign', array($CampaignIDInfo));
    }

    /**
     * Removes the campaign from the archive.
     *
     * @param Contract\CampaignIDInfo $CampaignIDInfo
     *
     * @return int 1 when executed successfully
     */
    public function unArchiveCampaign(Contract\CampaignIDInfo $CampaignIDInfo)
    {
        return $this->invoke('UnArchiveCampaign', array($CampaignIDInfo));
    }

    /**
     * Archives the campaign.
     *
     * @param Contract\CampaignIDInfo $CampaignIDInfo
     *
     * @return int 1 when executed successfully
     */
    public function archiveCampaign(Contract\CampaignIDInfo $CampaignIDInfo)
    {
        return $this->invoke('ArchiveCampaign', array($CampaignIDInfo));
    }

    /**
     * Allows ad displays for the campaign.
     *
     * @param Contract\CampaignIDInfo $CampaignIDInfo
     *
     * @return int 1 when executed successfully
     */
    public function resumeCampaign(Contract\CampaignIDInfo $CampaignIDInfo)
    {
        return $this->invoke('ResumeCampaign', array($CampaignIDInfo));
    }

    /**
     * Gets a list of campaign statistics reports that have been generated or are being generated.
     *
     * We don't recommend calling this method too often. On average, generating reports takes about
     * one to two minutes, so repeating calls for checking report status every 10-20 seconds
     * is frequent enough.
     *
     * @return Contract\ReportInfo[]
     */
    public function getReportList()
    {
        return $this->invoke('GetReportList', array());
    }

    /**
     * Checks API availability and whether the user was successfully authorized.
     *
     * @return int 1 when user authorization was successful
     */
    public function pingAPI()
    {
        return $this->invoke('PingAPI', array());
    }

    /**
     * Tells you how many points the user has.
     *
     * @param array $logins An array of user logins
     *
     * @return Contract\ClientsUnitInfo[]
     */
    public function getClientsUnits(array $logins)
    {
        return $this->invoke('GetClientsUnits', array($logins));
    }

    /**
     * Gets the user's personal data.
     *
     * @param array $logins An array of login names of the users whose personal data is being requested
     *
     * @return Contract\ClientInfo[]
     */
    public function getClientInfo(array $logins)
    {
        return $this->invoke('GetClientInfo', array($logins));
    }

    /**
     * Changes a user's personal data and permissions.
     *
     * @param Contract\ClientInfo[] $ClientInfo
     *
     * @return int 1 when data has been changed successfully
     */
    public function updateClientInfo(array $ClientInfo)
    {
        return $this->invoke('UpdateClientInfo', array($ClientInfo));
    }

    /**
     * Gets ad parameters.
     *
     * @param Contract\GetBannersInfo $GetBannersInfo
     *
     * @return Contract\BannerInfo[]
     */
    public function getBanners(Contract\GetBannersInfo $GetBannersInfo)
    {
        return $this->invoke('GetBanners', array($GetBannersInfo));
    }

    /**
     * Gets a list of campaigns with brief information about them.
     *
     * @param array $logins An array of login names. Is used only when making the request
     *                      on behalf of an advertising agency
     *
     * @return Contract\ShortCampaignInfo[]
     */
    public function getCampaignsList(array $logins = array())
    {
        return $this->invoke('GetCampaignsList', array($logins));
    }

    /**
     * Gets a list of campaigns that meet the filter conditions with brief information about these campaigns.
     *
     * @param Contract\GetCampaignsInfo $GetCampaignsInfo
     *
     * @return Contract\ShortCampaignInfo[]
     */
    public function getCampaignsListFilter(Contract\GetCampaignsInfo $GetCampaignsInfo)
    {
        return $this->invoke('GetCampaignsListFilter', array($GetCampaignsInfo));
    }

    /**
     * Gets information about the campaign balance.
     *
     * @param array $ids An array of IDs for campaigns that you need to get information for
     *
     * @return Contract\CampaignBalanceInfo[]
     */
    public function getBalance(array $ids)
    {
        return $this->invoke('GetBalance', array($ids));
    }

    /**
     * Gets information about phrases.
     *
     * @param array $ids An array of BannerID ad IDs (no more than 1000)
     *
     * @return Contract\BannerPhraseInfo[]
     */
    public function getBannerPhrases(array $ids)
    {
        return $this->invoke('GetBannerPhrases', array($ids));
    }

    /**
     * Gets information about phrases and lets you limit what is included in returned data.
     *
     * @param Contract\BannerPhrasesFilterRequestInfo $BannerPhrasesFilterRequestInfo
     *
     * @return Contract\BannerPhraseInfo[]
     */
    public function getBannerPhrasesFilter(Contract\BannerPhrasesFilterRequestInfo $BannerPhrasesFilterRequestInfo)
    {
        return $this->invoke('GetBannerPhrasesFilter', array($BannerPhrasesFilterRequestInfo));
    }

    /**
     * Gets a list of regions registered in Yandex.Direct.
     *
     * @return Contract\RegionInfo[]
     */
    public function getRegions()
    {
        return $this->invoke('GetRegions', array());
    }

    /**
     * Generates a campaign statistics report on the server.
     *
     * @param Contract\NewReportInfo $params
     *
     * @return int The ID of the future report
     */
    public function createNewReport(Contract\NewReportInfo $params)
    {
        return $this->invoke('CreateNewReport', array($params));
    }

    /**
     * Gets statistics that campaign for a period not exceeding seven days.
     *
     * @param Contract\NewReportInfo $params
     *
     * @return Contract\GetBannersStatResponse
     *
     * @since v4.live
     */
    public function getBannersStat(Contract\NewReportInfo $params)
    {
        return $this->invoke('GetBannersStat', array($params));
    }

    /**
     * Generates a report on the server about the projected number of impressions and clicks and campaign spending.
     *
     * The forecast is put together for one month for the specified phrases and Yandex.Catalog categories.
     *
     * @param Contract\NewForecastInfo $NewForecastInfo
     *
     * @return int The ID of the future report
     */
    public function createNewForecast(Contract\NewForecastInfo $NewForecastInfo)
    {
        return $this->invoke('CreateNewForecast', array($NewForecastInfo));
    }

    /**
     * Gets a report about the projected number of impressions, clicks and campaign spending.
     *
     * @param int $id The ID of the generated report
     *
     * @return Contract\GetForecastInfo
     */
    public function getForecast($id)
    {
        return $this->invoke('GetForecast', array($id));
    }

    /**
     * Gets a list of Yandex.Catalog categories.
     *
     * @return Contract\RubricInfo[]
     */
    public function getRubrics()
    {
        return $this->invoke('GetRubrics', array());
    }

    /**
     * Gets a list of time zones.
     *
     * @return Contract\TimeZoneInfo[]
     */
    public function getTimeZones()
    {
        return $this->invoke('GetTimeZones', array());
    }

    /**
     * Gets a list of reports that have been generated or are being generated about
     * the projected number of impressions, clicks and campaign spending.
     *
     * @return Contract\ForecastStatusInfo[]
     */
    public function getForecastList()
    {
        return $this->invoke('GetForecastList', array());
    }

    /**
     * For phrases, it sets the CPC on Yandex search and in the Yandex Advertising Network,
     * and also changes parameters for Autobudget and Autobroker.
     *
     * You can set prices for a maximum of 1000 phrases in a single request.
     *
     * @param Contract\PhrasePriceInfo[] $PhrasePriceInfo
     *
     * @return int 1 when executed successfully
     */
    public function updatePrices(array $PhrasePriceInfo)
    {
        return $this->invoke('UpdatePrices', array($PhrasePriceInfo));
    }

    /**
     * Creates a campaign with the specified parameters, or changes the parameters of an existing campaign.
     *
     * When editing a campaign, it is important to set all the optional parameters, even if they are not being changed.
     * If a parameter is omitted, its value may be replaced with the pre-set value.
     *
     * @param Contract\CampaignInfo $CampaignInfo
     *
     * @return int The ID of the created or edited campaign
     */
    public function createOrUpdateCampaign(Contract\CampaignInfo $CampaignInfo)
    {
        return $this->invoke('CreateOrUpdateCampaign', array($CampaignInfo));
    }

    /**
     * Creates an ad or edits the parameters of an existing ad.
     *
     * A campaign can have no more than 1000 ads, although the number of phrases per ad is not explicitly restricted.
     * There is a limit on the total size of phrases: 4096 bytes per ad.
     *
     * @param Contract\BannerInfo[] $BannerInfo
     *
     * @return array An array containing the IDs of created or updated ads
     */
    public function createOrUpdateBanners(array $BannerInfo)
    {
        return $this->invoke('CreateOrUpdateBanners', array($BannerInfo));
    }

    /**
     * Gets a list of API versions that are currently supported.
     *
     * @return Contract\VersionDesc[]
     */
    public function getAvailableVersions()
    {
        return $this->invoke('GetAvailableVersions', array());
    }

    /**
     * Gets suggestions for keywords.
     *
     * @param Contract\KeywordsSuggestionInfo $KeywordsSuggestionInfo
     *
     * @return array An array of suggestions for the keywords (up to 20 suggestions)
     */
    public function getKeywordsSuggestion(Contract\KeywordsSuggestionInfo $KeywordsSuggestionInfo)
    {
        return $this->invoke('GetKeywordsSuggestion', array($KeywordsSuggestionInfo));
    }

    /**
     * Registers a client of an advertising agency.
     *
     * @param Contract\CreateNewSubclientRequest $CreateNewSubclientRequest
     *
     * @return Contract\CreateNewSubclientResponse
     */
    public function createNewSubclient(Contract\CreateNewSubclientRequest $CreateNewSubclientRequest)
    {
        return $this->invoke('CreateNewSubclient', array($CreateNewSubclientRequest));
    }

    /**
     * Generates a search query statistics report on the server.
     *
     * @param Contract\NewWordstatReportInfo $NewWordstatReportInfo
     *
     * @return int The ID of the future report
     */
    public function createNewWordstatReport(Contract\NewWordstatReportInfo $NewWordstatReportInfo)
    {
        return $this->invoke('CreateNewWordstatReport', array($NewWordstatReportInfo));
    }

    /**
     * Gets a list of query statistics reports that have been generated or are being generated.
     *
     * @return Contract\WordstatReportStatusInfo[]
     */
    public function getWordstatReportList()
    {
        return $this->invoke('GetWordstatReportList', array());
    }

    /**
     * Gets a search query statistics report.
     *
     * @param int $id The ID of the generated report
     *
     * @return Contract\WordstatReportInfo[]
     */
    public function getWordstatReport($id)
    {
        return $this->invoke('GetWordstatReport', array($id));
    }

    /**
     * Deletes a search query statistics report.
     *
     * @param int $id The ID of the generated report
     *
     * @return int 1 when the report is deleted successfully
     *
     * @since v4
     */
    public function deleteWordstatReport($id)
    {
        return $this->invoke('DeleteWordstatReport', array($id));
    }

    /**
     * Gets information about the Yandex.Metrica goals that are available for the campaign.
     *
     * @param Contract\StatGoalsCampaignIDInfo $params
     *
     * @return Contract\StatGoalInfo[]
     */
    public function getStatGoals(Contract\StatGoalsCampaignIDInfo $params)
    {
        return $this->invoke('GetStatGoals', array($params));
    }

    /**
     * Checks for changes in campaigns and ads, as well as in the region and time zone directories,
     * and in the Yandex.Catalog.
     *
     * @param Contract\GetChangesRequest $GetChangesRequest
     *
     * @return Contract\GetChangesResponse
     *
     * @since v4
     */
    public function getChanges(Contract\GetChangesRequest $GetChangesRequest)
    {
        return $this->invoke('GetChanges', array($GetChangesRequest));
    }

    /**
     * Gets the entries from the event log.
     *
     * @param Contract\GetEventsLogRequest $params
     *
     * @return Contract\EventsLogItem[]
     *
     * @since v4.live
     */
    public function getEventsLog(Contract\GetEventsLogRequest $params)
    {
        return $this->invoke('GetEventsLog', array($params));
    }

    /**
     * Gets an array of tags for specific campaigns.
     *
     * @param Contract\CampaignIDSInfo $params
     *
     * @return Contract\CampaignTagsInfo[]
     *
     * @since v4.live
     */
    public function getCampaignsTags(Contract\CampaignIDSInfo $params)
    {
        return $this->invoke('GetCampaignsTags', array($params));
    }

    /**
     * Updates tags of campaigns.
     *
     * @param Contract\CampaignTagsInfo[] $params
     *
     * @return Contract\CampaignTagsInfo[]
     *
     * @since v4.live
     */
    public function updateCampaignsTags(array $params)
    {
        return $this->invoke('UpdateCampaignsTags', array($params));
    }

    /**
     * Gets an array of tags for specific banners.
     *
     * @param Contract\BannersRequestInfo $params
     *
     * @return Contract\BannerTagsInfo[]
     *
     * @since v4.live
     */
    public function getBannersTags(Contract\BannersRequestInfo $params)
    {
        return $this->invoke('GetBannersTags', array($params));
    }

    /**
     * Updates tags of banners.
     *
     * @param Contract\BannerTagsInfo[] $params
     *
     * @return int
     *
     * @since v4.live
     */
    public function updateBannersTags(array $params)
    {
        return $this->invoke('UpdateBannersTags', array($params));
    }

    /**
     * Transfers funds between campaigns.
     *
     * @param Contract\TransferMoneyInfo $TransferMoneyInfo
     *
     * @return int 1 when executed successfully
     *
     * @since v4
     */
    public function transferMoney(Contract\TransferMoneyInfo $TransferMoneyInfo)
    {
        return $this->invoke('TransferMoney', array($TransferMoneyInfo), true);
    }

    /**
     * Gets information about credit available to pay for campaigns.
     *
     * @return Contract\CreditLimitsInfo
     *
     * @since v4
     */
    public function getCreditLimits()
    {
        return $this->invoke('GetCreditLimits', array(), true);
    }

    /**
     * Generates an invoice in HTML format for paying for one or more campaigns.
     *
     * @param Contract\CreateInvoiceInfo $CreateInvoiceInfo
     *
     * @return string If executed successfully, the method returns the URL of the payment invoice
     *
     * @since v4
     */
    public function createInvoice(Contract\CreateInvoiceInfo $CreateInvoiceInfo)
    {
        return $this->invoke('CreateInvoice', array($CreateInvoiceInfo), true);
    }

    /**
     * Pays for the campaign using available credit.
     *
     * @param Contract\PayCampaignsInfo $PayCampaignsInfo
     *
     * @return int 1 when executed successfully
     *
     * @since v4
     */
    public function payCampaigns(Contract\PayCampaignsInfo $PayCampaignsInfo)
    {
        return $this->invoke('PayCampaigns', array($PayCampaignsInfo), true);
    }

    /**
     * Gets an array of RetargetingGoal instances.
     *
     * @param Contract\GetRetargetingGoalsRequest $params
     *
     * @return Contract\RetargetingGoal[]
     *
     * @since v4.live
     */
    public function getRetargetingGoals(Contract\GetRetargetingGoalsRequest $params)
    {
        return $this->invoke('GetRetargetingGoals', array($params));
    }

    /**
     * Retargeting condition.
     *
     * @param Contract\RetargetingConditionRequest $params
     *
     * @return Contract\RetargetingConditionResponse
     *
     * @since v4.live
     */
    public function retargetingCondition(Contract\RetargetingConditionRequest $params)
    {
        return $this->invoke('RetargetingCondition', array($params));
    }

    /**
     * Retargeting
     *
     * @param Contract\RetargetingRequest $params
     *
     * @return Contract\RetargetingResponse
     *
     * @since v4.live
     */
    public function retargeting(Contract\RetargetingRequest $params)
    {
        return $this->invoke('Retargeting', array($params));
    }

    /**
     * Manages ad image.
     *
     * @param Contract\AdImageRequest $params
     *
     * @return Contract\AdImageResponse
     *
     * @since v4.live
     */
    public function adImage(Contract\AdImageRequest $params)
    {
        return $this->invoke('AdImage', array($params));
    }

    /**
     * Manages associations of ad image.
     *
     * @param Contract\AdImageAssociationRequest $params
     *
     * @return Contract\AdImageAssociationResponse
     *
     * @since v4.live
     */
    public function adImageAssociation(Contract\AdImageAssociationRequest $params)
    {
        return $this->invoke('AdImageAssociation', array($params));
    }

    /**
     * Enables shared account for specific client.
     *
     * @param Contract\EnableSharedAccountRequest $params
     *
     * @return Contract\EnableSharedAccountResponse
     *
     * @since v4.live
     */
    public function enableSharedAccount(Contract\EnableSharedAccountRequest $params)
    {
        return $this->invoke('EnableSharedAccount', array($params));
    }

    /**
     * Manages shared account.
     *
     * @param Contract\AccountManagementRequest $params
     *
     * @return Contract\AccountManagementResponse
     *
     * @since v4.live
     */
    public function AccountManagement(Contract\AccountManagementRequest $params)
    {
        return $this->invoke('AccountManagement', array($params));
    }

    /**
     * Invokes API method with specified name.
     *
     * @param string $method            A method name
     * @param array  $params            An array of parameters for API method
     * @param bool   $isFinancialMethod If true, when should be send the finance token
     *
     * @throws \Exception
     *
     * @return mixed
     */
    private function invoke($method, array $params = array(), $isFinancialMethod = false)
    {
        $this->dispatcher->dispatch(Events::BEFORE_REQUEST, new PreCallEvent(
            $this,
            $method,
            $this->client->getConfiguration()
        ));

        try {
            $response = $this->client->invoke($method, $params, $isFinancialMethod);
        } catch (\Exception $ex) {
            $this->dispatcher->dispatch(Events::FAIL_REQUEST, new FailCallEvent(
                $this,
                $method,
                $this->client->getConfiguration(),
                $params,
                $ex
            ));

            throw $ex;
        }

        $this->dispatcher->dispatch(Events::AFTER_REQUEST, new PostCallEvent(
            $this,
            $method,
            $this->client->getConfiguration(),
            $response
        ));

        return $response;
    }
}
