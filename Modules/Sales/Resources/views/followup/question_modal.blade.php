<div class="modal fade questionModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Client Questions</h5>
                <span type="button" class="btn-close" style="cursor: pointer; font-size:20px; color:red"
                    data-dismiss="modal"><i class="fas fa-window-close"></i></span>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left">1. Reason Behind Client switching ISP ?
                                </td>
                                <td>
                                    <input type="text" name="reason_of_switching" class="form-control"
                                        id="reason_of_switching" autocomplete="off" placeholder="" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">2. Is there any LAN issue on client site ? </td>
                                <td>
                                    <input type="text" name="lan_issue" class="form-control" id="lan_issue"
                                        autocomplete="off" placeholder="" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">3.What devices client at present have ?</td>
                                <td>
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" name="device[]" value="Router">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                            <span>Router</span>
                                        </label>
                                    </div>
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" name="device[]" value="Access Point">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                            <span>Access Point</span>
                                        </label>
                                    </div>
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" name="device[]" value="Switch">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                            <span>Switch</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">4. Client devices capable to handle requested bandwidth ? </td>
                                <td>
                                    <input type="text" name="capability_of_bandwidth" class="form-control"
                                        id="capability_of_bandwidth" autocomplete="off" placeholder="" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">5. Any additional devices connected with LAN ?</td>
                                <td>
                                    <input type="text" name="device_connected_with_lan" class="form-control"
                                        id="device_connected_with_lan" autocomplete="off" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">6. Does client use licensed Windows / Antivirus ?</td>
                                <td>
                                    <input type="text" name="license_of_antivirus" class="form-control"
                                        id="license_of_antivirus" autocomplete="off" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">7. Does client have any designated IT Personnel available at
                                    client site ?</td>
                                <td>
                                    <input type="text" name="client_site_it_person" class="form-control"
                                        id="client_site_it_person" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">8. Does client have any own mail domain ?</td>
                                <td>
                                    <div class="form-radio">
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="mail_domain" value="Yes">
                                                <i class="helper"></i>Yes
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="mail_domain" value="No">
                                                <i class="helper"></i>No
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="mail_domain" value="ON Prem Server">
                                                <i class="helper"></i>ON Prem Server
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="mail_domain" value="Cloud Server">
                                                <i class="helper"></i>Cloud Server
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">9. Client have any Virtual Private Network (VPN) requirement ?
                                </td>
                                <td>
                                    <div class="form-radio">
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="vpn_requirement" value="Yes">
                                                <i class="helper"></i>Yes
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="vpn_requirement" value="No">
                                                <i class="helper"></i>No
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="vpn_requirement"
                                                    value="Domestic Purpose">
                                                <i class="helper"></i>Domestic Purpose
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="vpn_requirement" value="Internationally">
                                                <i class="helper"></i>Internationally
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">10. Client have any Video Conferencing (VC) requirement ?</td>
                                <td>
                                    <div class="form-radio">
                                        <div class="form-radio">
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="video_conferencing" value="Yes">
                                                    <i class="helper"></i>Yes
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="video_conferencing" value="No">
                                                    <i class="helper"></i>No
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="video_conferencing"
                                                        value="Domestic Purpose">
                                                    <i class="helper"></i>Domestic Purpose
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="video_conferencing"
                                                        value="Internationally">
                                                    <i class="helper"></i>Internationally
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">11. Client have any IPTSP Service Usage ?</td>
                                <td>
                                    <div class="form-radio">
                                        <div class="form-radio">
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="iptsp_service_usage" value="Yes">
                                                    <i class="helper"></i>Yes
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="iptsp_service_usage" value="No">
                                                    <i class="helper"></i>No
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="iptsp_service_usage"
                                                        value="Domestic Purpose">
                                                    <i class="helper"></i>Domestic Purpose
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="iptsp_service_usage"
                                                        value="Internationally">
                                                    <i class="helper"></i>Internationally
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">12. Does client use any software usage such as ERP / Tally etc ?
                                </td>
                                <td>
                                    <div class="form-radio">
                                        <div class="form-radio">
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="software_usage" value="Yes">
                                                    <i class="helper"></i>Yes
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="software_usage" value="No">
                                                    <i class="helper"></i>No
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="software_usage"
                                                        value="Domestic Purpose">
                                                    <i class="helper"></i>Domestic Purpose
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="software_usage"
                                                        value="Internationally">
                                                    <i class="helper"></i>Internationally
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">13. Any specific destination client shares their data with? (e.g:
                                    China / India
                                    etc.)</td>
                                <td>
                                    <input type="text" name="specific_destination" class="form-control"
                                        id="specific_destination" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">14. Does client want 99-100% uptime clause applicable in their
                                    SLA ?</td>
                                <td>
                                    <div class="form-radio">
                                        <div class="form-radio">
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="uptime_capable_sla" value="Yes">
                                                    <i class="helper"></i>Yes  
                                                </label>
                                            </div>
                                            <div class="radio radio-outline radio-inline">
                                                <label>
                                                    <input type="radio" name="uptime_capable_sla" value="No">
                                                    <i class="helper"></i>No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">15. Present ISP providing redundant connectivity ?</td>
                                <td>
                                    <input type="text" name="isp_providing" class="form-control"
                                        id="isp_providing" autocomplete="off">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-outline-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-outline-primary">Save</button>
            </div>
        </div>
    </div>
</div>
