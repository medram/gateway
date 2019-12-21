<?php
require_once "init.php";

use MR4Web\Utils\View;
$data['title'] = 'Terms of Use';
$data['pageContent'] = "
    <p>
      By using the ".getConfig('site_name')." ('service'), you are agreeing to be bound by the
      following terms and conditions ('terms of service').
    </p>
    <!--<p>
      ".getConfig('site_name').", LLC ('company') reserves the right to update and change these
      terms of service without notice.
    </p>-->
    <p>
      Violation of any of the terms below may result in the termination of your
      account.
    </p>

    <hr>

    <h3>Account terms</h3>
    <p>
      You are responsible for maintaining the security of your account and
      password. The company cannot and will not be liable for any loss or
      damage from your failure to comply with this security obligation.
    </p>
    <p>
      You are responsible for all content posted and activity that occurs under
      your account.
    </p>
    <p>
      You may not use the service for any illegal purpose or to violate any laws
      in your jurisdiction (including but not limited to copyright laws).
    </p>
    <p>
      You must provide your legal full name, a valid email address, and any other
      information requested in order to complete the optional paid membership
      signup process.
    </p>
    <p>
      Your login may only be used by one person — a single login shared
      by multiple people is not permitted. You may create separate logins for
      as many people as you'd like.
    </p>
    <p>
      You must be a human. Accounts registered by 'bots' or other automated
      methods are not permitted.
    </p>
        
    <hr>
    
    <h3>Payment, refunds, upgrading and downgrading terms</h3>
    <p>
      The service is offered for free with an option to sign up for more
      features with a free trial. Once that trial is up, you will only be able
      to continue using that plan's features by paying in advance for additional
      usage. If you fail to pay for additional usage, your account will be
      downgraded until payment is made.
    </p>
    <p>
      For any upgrade or downgrade in plan level, will result in the new rate
      being charged at the next billing cycle. There will be no prorating for
      downgrades in between billing cycles.
    </p>
    <p>
      Downgrading your service may cause the loss of features or capacity of
      your account. The company does not accept any liability for such loss.
    </p>
    <p>
      All fees are exclusive of all taxes, levies, or duties imposed by taxing
      authorities, and you shall be responsible for payment of all such taxes,
      levies, or duties, excluding only United States (federal or state) taxes.
    </p>
    <p>Refunds are processed according to our fair refund policy.</p>
    
    <hr>
    
    <h3>Cancellation and termination</h3>
    <p>
      You are solely responsible for properly canceling your account. An email
      or phone request to cancel your account is not considered cancellation.
      You can cancel your account at any time by clicking on the Settings
      link
      in the global navigation bar at the top of the screen. The Settings
      screen provides a simple no-questions-asked cancellation link.
    </p>
    <p>
      All of your content will be immediately be inaccessible from the service
      upon cancellation. Within 30 days, all this content will be permanently
      deleted from all backups and logs. This information can not be
      recovered
      once it has been permanently deleted.
    </p>
    <p>
      If you cancel the service before the end of your current paid up month,
      your cancellation will take effect immediately, and you will not be charged
      again. But there will not be any prorating of unused time in the last
      billing cycle.
    </p>
    <p>
      The company, in its sole discretion, has the right to suspend or
      terminate your account and refuse any and all current or future use of
      the service for any reason at any time. Such termination of the service
      will result in the deactivation or deletion of your account or your access
      to your account, and the forfeiture and relinquishment of all content in
      your account. The company reserves the right to refuse service to anyone
      for any reason at any time.
    </p>
        
    <hr>
    
    <h3>Modifications to the service and prices</h3>
    <p>
      The company reserves the right at any time and from time to time to modify
      or discontinue, temporarily or permanently, any part of the service with
      or without notice.
    </p>
    <p>
      Prices of all services are subject to change upon 30 days notice from
      us. Such notice may be provided at any time by posting the changes to
      the company's site or the service itself.
    </p>
    <p>
      The company shall not be liable to you or to any third party for any
      modification, price change, suspension or discontinuance of the service.
    </p>
        
    <hr>
    
    <h3>Copyright and content ownership</h3>
    <p>
      All content posted on the service must comply with U.S. copyright law.
    </p>
    <p>
      We claim no intellectual property rights over the material you provide
      to the service. All materials uploaded remain yours.
    </p>
    <p>
      The company does not pre-screen content, but reserves the right (but not
      the obligation) in their sole discretion to refuse or remove any content
      that is available via the service.
    </p>
    <p>
      The look and feel of the service is copyright© ".getConfig('site_name').", LLC.
      All rights reserved. You may not duplicate, copy, or reuse any portion
      of the HTML, CSS, JavaScript, or visual design elements without express
      written permission from the company.
    </p>
        
    <hr>
    
    <h3>General conditions</h3>

    <p>Technical support is only provided via email.</p>
    <p>
      You understand that the company uses third party vendors and hosting
      partners to provide the necessary hardware, software, networking,
      storage, and related technology required to run the service.
    </p>
    <p>You must not modify, adapt or hack the service.</p>
    <p>
      You must not modify another website so as to falsely imply that it is
      associated with the service or the company.
    </p>
    <p>
      You agree not to reproduce, duplicate, copy, sell, resell or exploit any
      portion of the service, use of the service, or access to the service
      without the express written permission by the company.
    </p>
    <p>
      We may, but have no obligation to, remove content and accounts that we
      determine in our sole discretion are unlawful or violates any party's
      intellectual property or these terms of service.
    </p>
    <p>
      Verbal, physical, written or other abuse (including threats of abuse or
      retribution) of any service customer, company employee or officer will
      result in immediate account termination.
    </p>
    <p>
      You understand that the technical processing and transmission of the
      service, including your content, may be transferred unencrypted and
      involve (a) transmissions over various networks; and (b) changes to conform
      and adapt to technical requirements of connecting networks or devices.
    </p>
    <p>
      The company does not warrant that (i) the service will meet your
      specific requirements, (ii) the service will be uninterrupted, timely,
      secure, or error-free, (iii) the results that may be obtained from the
      use of the service will be accurate or reliable, (iv) the quality of any
      products, services, information, or other material purchased or obtained
      by you through the service will meet your expectations, and (v) any
      errors in the service will be corrected.
    </p>
    <p>
      You expressly understand and agree that the company shall not be liable
      for any direct, indirect, incidental, special, consequential or exemplary
      damages, including but not limited to, damages for loss of profits,
      goodwill, use, data or other intangible losses (even if the company has
      been advised of the possibility of such damages), resulting from: (i) the
      use or the inability to use the service; (ii) the cost of procurement
      of substitute goods and services resulting from any goods, data, information
      or services purchased or obtained or messages received or transactions
      entered into through or from the service; (iii) unauthorized access to
      or alteration of your transmissions or data; (iv) statements or conduct of
      any third party on the service; (v) or any other matter relating to the
      service.
    </p>
    <p>
      The failure of the company to exercise or enforce any right or provision
      of the terms of service shall not constitute a waiver of such right or
      provision. The terms of service constitutes the entire agreement
      between you and the company and govern your use of the service, super-ceding
      any prior agreements between you and the company (including, but not
      limited to, any prior versions of the terms of service).
    </p>
    <p>
      Questions about the terms of service should be sent to
      <a href='contact-us.php'>Contact us page</a>.
    </p>
    <p>
      Any new features that augment or enhance the current service, including
      the release of new tools and resources, shall be subject to the terms
      of service. Continued use of the service after any such changes shall
      constitute your consent to such changes.
    </p>

";

View::render('header', $data);
View::render('pageTpl', $data);
View::render('footer', $data);
?>