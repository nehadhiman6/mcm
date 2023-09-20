@if(isset($guard) && $guard == 'students')
<fieldset class="terms">
    <legend><h4>Filling of Online College Admission Form</h4></legend>
	
	<h4><strong>There are two modes of admission with reference to different classes:</strong></h4>
		<h5><strong>A.	Online College Admission (Regulated by College)</strong></h5>
		<h5><strong>B.	Online Centralized Admission (Regulated by DHE)</strong></h5>

        <span style="color: blue;"><b>Important</b></span>
        <li><b>Online College Admission Form is to be filled by all the applicants seeking admission in the college.</b></li>
        <li><b>Applicants</b> seeking admission to courses regulated through <b>Online Centralized Admission</b> are also required to fill the Online College Admission Form <b>only if their name appears in the merit list of Mehr Chand Mahajan DAV College for Women.</b></li>
                    <li>Filling Online Admission Form (for <b>non-centralized courses</b>) does not imply or guarantee the following:</li>
                    <ul class="instruction-ul">
                        <li>Admission to the applied course</li>
                        <li>Subject combination applied for</li>
                        <li>Honours allotment </li>
                    </ul>
                        <li>Students must bring the following whenever notified by college authorities:</li>
					<ul class="instruction-ul">	
						<li>Original certificates</li>
						<li>Print-out of duly filled Admission Form</li>
						<li>Fee Payment Receipt</li>
                    </ul>    
						<li><b>All admissions are provisional and subject to:</b></li>
                    <ul class="instruction-ul">
                        <li>Scrutiny of the Admission Form</li>
                        <li>Verification of Original Documents</li>
                        <li>Recommendation of Admission Committee</li>
                        <li>Completion of all the other college formalities</li>
                        <li>Approval of Panjab University, Chandigarh</li>
                    </ul>
						<li>Online Fee Payment</li>
					<ul class="instruction-ul">
						<li>After completing admission formalities, pay College Fee Online.</li>
                        <li>Online Fee Payment options: Credit Card/Debit Card/Net Banking/Paytm</li>
                        <li>To check payment status: login to registered student account and check successful status of Fee Payment</li>
					</ul>
                <br>
                <span style="color: blue;"><b>Scanned Documents required for uploading</b></span>
                <li>Scanned photographs in <b>.jpg, .png,</b> format (not more than 50KB in size)</li>
                <li>Scanned copy of applicant’s signatures in <b>.jpg, .png,</b> (not more than 20 KB)</li>
				<li>Scanned copy of parent’s / guardian’s  signatures in <b>.jpg, .png,</b> (not more than 20 KB)</li>
                <li>Detailed mark sheets in <b>pdf</b> format (not more than 300KB)</li>
                <li>BPL affidavit/certificate in <b>pdf</b> format (not  more than 300KB)  </li>
                <li>The candidate must have her personal valid email id that will be used for official communication during her course of education in the college and beyond.</li>
                <br>
        
        
                <span style="color: blue;"><b>Instructions to fill the Online Application Form</b></span>
                <li>New Applicant to click on Register</li>
                <li>Registered Applicant to click on Login</li>
                <li>All the columns of the Online Form should be filled carefully</li>
                <li>All the columns marked (*) are mandatory</li>
				<b>Note:</b>
				<li>One email ID can be used to apply/register for a single course only.</li>
				<li>If Applicant wishes to apply for more than one course, she would have to use a separate email ID for applying / registering for the same.</li>
                <br>
				<li><b>Applicant applying for BA I must give 6 preferences for elective subject combinations.</b></li>
                <li>Complete the Online Form. Incomplete forms will not be accepted.</li>
                <li>Upload photograph, signature image and the other applicable documents</li>
                <li>Preview the Application Form and make corrections (if any)</li>
                <li>Pay your processing fee (Payment options: Credit Card, Debit Card, Net Banking, Paytm)</li>
                <li>No changes in the form are allowed after the final submission</li>
                <li><b>Make final submission by clicking on ‘Final Submission’</b></li>
                
                
                <br>
                <b>Documents to be attached with the Printout of the Admission form (Whenever intimated by college authorities)</b>
                <li><b>New students</b> should attach self-attested photocopies of the following documents:</li>
                    <ul class="instruction-ul">
                        <li>Detailed Marks Certificates of all the results mentioned in Academic Record Column</li>
                        <li>Date of Birth Certificate (Class X Mark Sheet)</li>
                        <li>Character Certificate by the School/College last attended</li>
                        <li>Proof of seeking exemption in Punjabi Compulsory (Class X Standard Mark Sheet) (Only for Undergraduate Courses)</li>
                        <li>Anti-ragging declaration must be signed by all students</li>
                        <li>Affidavits:</li>
                    </ul>
                    <ul class="sub-instruction-ul">
                        <li>Gap year (if any, submit two copies in original)</li>
                        <li>Girl child category affidavit (on a stamp paper worth Rs 20/-) duly attested by a first class magistrate. Parents must declare that the benefit is obtained for only one girl child in case of two girl children.</li>
                        <li>Reserved / any other relevant category </li>
                    </ul>
                <li>Other Certificates required (if applicable)</li>
                    <ul class="instruction-ul">
                        <li>Migration Certificate (for students of other Boards/Universities)</li>
                        <li>Cancer, AIDS and Thalassemia patients seeking addmission must attach a certificate of proof from National Medical Institutes like PGI, AIIMS etc.</li>
                        <li>Achievements in sports if seeking admission against sports seat</li>
                        <li>Eligibility Certificate (for Foreign Students only)</li>
                    </ul>
                <li>A student whose result of Class XII examination conducted by her respective School Board is published late, may be admitted without late fee within 15 working days of the declaration of the result and her attendance will be counted from the date of admission.</li>
                <li>Students seeking admission to Postgraduate courses must also attach scanned copies of detailed mark sheets of all:</li>
                    <ul class="instruction-ul">    
                        <li>Six semesters of the graduate degree </li>
                        <li>Honours mark sheet </li>
                    </ul>
                <li><b>Old students</b> of the College (Undergraduate & Postgraduate) should attach scanned copies of the marksheets of all preceding semester examinations.</li>
       <br>
    @if($mainTitle != 'hide')
       {!! Form::label('instructions',' I certify that I have read and understood the College Prospectus available online. I have read and understood the above given instructions.',['class' => 'col-sm-9  control-label']) !!}
    
        <div class="col-sm-2">
            <label class="checkbox">
                <input type="checkbox" name="instructions" v-model = 'instructions' v-bind:true-value="'Y'"
                    v-bind:false-value="'N'" class="minimal">
            </label>
            
            <input class="btn btn-primary"  type="submit" value="Continue" :disabled="instructions == 'N'" @click.prevent="proceedClick">
        </div>
    @endif 
</fieldset>
@endif