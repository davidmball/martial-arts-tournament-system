{config_load file=test.conf}
{include file="header.tpl"}

<div id="main_pane">

<h1>Help / FAQ</h1>

<b>General</b><br>
<a href="#age_wrong">Why is my age wrong?</a><br>
<a href="#no_divisions">Why can't I see the divisions for the tournament?</a><br>
<a href="#who_sign_up">Who can sign up?</a><br>
<a href="#how_sign_up">How do I sign up?</a><br>
<a href="#email_problems">Why haven't I received an email from MATS?</a><br>

{if $user_access == "admin" || $user_access == "manager"}
<br>
<b>Managers</b><br>

<a href="#payment">I have paid HQ for that student, why hasn't it shown up as paid?</a><br>
<a href="#wrong_division">Why is a student in the wrong division?</a><br>
<a href="#wrong_event">Why is a student in the wrong event?</a><br>
<a href="#cant_edit">What can't I edit my competitor's details?</a><br>
<a href="#reenter_details">Why do I have to reenter my competitor's details for each tournament?</a><br>
{/if}

<h1>General</h1>

<strong><a name="age_wrong">Why is my age wrong?</a></strong>
<p>
The MATS system displays the age you will be on the first day of the active tournament.
This is the age used for working out your division and the amount you need to pay.
</p>

<strong><a name="no_divisions">Why can't I see the divisions for the tournament?</a></strong>
<p>
Probably because they haven't been released yet. They are generally released only a few days before the tournament.
</p>

<strong><a name="who_sign_up">Who can sign up?</a></strong>
<p>
Only:
<li> team managers and instructors who need to enter their competitor's details, and
<li> tournament directors and officials that need access to the division and timetable systems.
</p>

<strong><a name="how_sign_up">How do I sign up?</a></strong>
<p>
Click the "Contact Us or Sign Up" menu item, enter your details, select "Sign Up" for the subject.
Note this may take up to 48 hours to be processed.
</p>

<strong><a name="email_problems">Why haven't I received an email from MATS?</a></strong>
<p>
This could be for a number of reasons:
<li> you or an admin hasn't entered your email address correctly - change your email yourself or contact us
<li> your email system's SPAM filter is getting the message - most email systems have the option to set email addresses
that should not go to spam. Include tournament (at) bairui (dot) com in your approved list.
</p>

{if $user_access == "admin" || $user_access == "manager"}
<h1>Managers</h1>

<strong><a name="payment">I have paid HQ that student, why hasn't it shown up as paid?</a></strong>
<p>
It can take a few days for HQ to process payments. If it hasn't shown up in a few days either click Contact Us or contact HQ directly.
</p>

<strong><a name="wrong_division">Why is a student in the wrong division?</a></strong>
<p>
First note that students are divisioned based on their age on the first day of the tournament. If this isn't the problem then use the Contact Us link.
</p>

<strong><a name="wrong_event">Why is a student in the wrong event?</a></strong>
<p>
Check that they are entered correctly in the registration page. Regardless, Contact Us.
</p>

<strong><a name="cant_edit">What can't I edit my competitor's details?</strong>
<p>
A few days out from the tournament the divisions will be locked to prevent managers from making changes. Any changes must be submitted using Contact Us.
</p>

<strong><a name="reenter_details">Why do I have to reenter my competitor's details for each tournament?</a></strong>
<p>
To ensure that the details are accurate to the paperwork, MATS enforces re-entering your competitor's details.
</p>
{/if}

{include file="footer.tpl"}
</body>
</div>