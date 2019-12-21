<?php
require_once "init.php";

use MR4Web\Utils\View;
$domain = DOMAIN;
$data['title'] = 'Privacy Policy';
$data['pageContent'] = "
  <p>
    This privacy policy discloses the privacy practices for 
    <a href='${domain}'>${domain}</a>.
    This privacy policy applies solely to information collected by this web
    site. It will notify you of the following:
  </p>
  <ul>
    <li>
      What personally identifiable information is collected from you through
      the web site, how it is used and with whom it may be shared.
    </li>
    <li>
      What choices are available to you regarding the use of your data.
    </li>
    <li>
      The security procedures in place to protect the misuse of your information.
    </li>
    <li>How you can correct any inaccuracies in the information.</li>
  </ul>

  <hr>

  <h3>Information collection, use, and sharing</h3>
  <p>
    We are the sole owners of the information collected on this site. We
    only have access to/collect information that you voluntarily give us via
    email or other direct contact from you. We will not sell or rent this
    information to anyone.
  </p>
  <p>
    We will use your information to respond to you, regarding the reason you
    contacted us. We will not share your information with any third party
    outside of our organization, other than as necessary to fulfill your
    request, e.g. to process a credit card.
  </p>
  <p>
    Unless you ask us not to, we may contact you via email in the future to
    tell you about specials, new products or services, or changes to this
    privacy policy.
  </p>
    
  <hr>
  
  <h3>Your access to and control over information</h3>
  <p>
    You may opt out of any future contacts from us at any time. You can do the
    following at any time by contacting us via the email address or phone
    number given on our website:
  </p>
  <ul>
    <li>See what data we have about you, if any.</li>
    <li>Change/correct any data we have about you.</li>
    <li>Have us delete any data we have about you.</li>
    <li>Express any concern you have about our use of your data.</li>
  </ul>
  
  <hr>
  
  <h3>Security</h3>
  <p>
    We take precautions to protect your information. When you submit sensitive
    information via the website, your information is protected both online and
    offline.
  </p>
  <p>
    Wherever we collect sensitive information (such as credit card data),
    that information is encrypted and transmitted to us in a secure way.
    You can verify this by looking for a closed lock icon at the bottom of your
    web browser, or looking for 'https' at the beginning of the address of
    the web page.
  </p>
  <p>
    While we use encryption to protect sensitive information transmitted
    online, we also protect your information offline. Only employees who
    need the information to perform a specific job (for example, billing or
    customer service) are granted access to personally identifiable information.
    The computers/servers in which we store personally identifiable information
    are kept in a secure environment.
  </p>

  <h4>Credit card information</h4>
  <p>
    We do not store your credit card information directly. It is passed
    through to a third party credit card processing merchant using 128-bit / 256-bit
    SSL encryption. We only keep your credit card's brand, last 4 digits and
    expiration date to assist and remind you of any billing related issues.
  </p>

  <hr>

  <h3>Cookies</h3>
  <p>
    We use 'cookies' on this site. A cookie is a piece of data stored on a
    site visitor's hard drive to help us improve your access to our site
    and identify repeat visitors to our site. For instance, when we use a
    cookie to identify you, you would not have to log in with a password more
    than once, thereby saving time while on our site. Cookies can also enable us
    to track and target the interests of our users to enhance the experience
    on our site. Usage of a cookie is in no way linked to any personally
    identifiable information on our site.
  </p>
  <p>
    If you do not want to be tracked by Google Analytics you may opt-out using
    <a target='_blank' href='https://tools.google.com/dlpage/gaoptout/'>
      Google's official opt-out browser add-on
    </a>.
  </p>

  <hr>
  
  <h3>Links</h3>
  <p>
    This web site contains links to other sites. Please be aware that we are
    not responsible for the content or privacy practices of such other sites.

    We encourage our users to be aware when they leave our site and to read
    the privacy statements of any other site that collects personally
    identifiable information.
  </p>

  <hr>
  
  <h3>Updates</h3>
  <p>
    Our privacy policy may change from time to time and all updates will be
    posted on this page.
  </p>

  <p>
    If you feel that we are not abiding by this privacy policy, you should
    contact us immediately via email (<a href='contact-us.php'>Contact Us page</a>).
  </p>
";

View::render('header', $data);
View::render('pageTpl', $data);
View::render('footer', $data);
?>