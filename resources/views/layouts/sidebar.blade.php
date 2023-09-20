@if(auth()->check())
   <div class="page-sidebar custom-scroll" id="sidebar">
      <div class="sidebar-header">
         <a class="sidebar-brand" href="{{url('/')}}">
            <img src="{{ url('img/logo.jpg')}}" width="40px;" /> MCM College
         </a>
         <a class="sidebar-brand-mini" href="{{url('/')}}"><img src="{{ url('img/logo.jpg')}}" width="40px;" /></a>
      </div>
      <ul class="sidebar-menu metismenu">
         {{-- <li class="heading"><span>DASHBOARDS</span></li> --}}
         
         <li class="{{ checkActive(['/']) }}">
            <a href="{{url('/')}}"><i class="sidebar-item-icon ft-home"></i><span class="nav-label">Dashboards</span></a>
         </li>
         
            <li>
               {{-- @if(Gate::check('ADMISSION-FORMS') || Gate::check('NEW-ADMISSION-FORMS') || Gate::check('SUBJECT-WISE-STRENGTH') || Gate::check('online-transactions') || Gate::check('ADMISSION-ENTRY') || Gate::check('NEW-ADMISSION-ENTRY')) --}}
                  <a href="javascript:;"><i class="sidebar-item-icon ft-layers">
                     </i><span class="nav-label">College/Hostel Admission</span><i class="arrow la la-angle-right"></i>
                  </a>
               {{-- @endif --}}
               <ul class="nav-2-level">

                  @if(hasAccessToMenuOption(['ADMISSION-FORMS', 'NEW-ADMISSION-FORMS', 'SUBJECT-WISE-STRENGTH','online-transactions']))
                     <li class="{{ checkActive(['admission-formm','sub-admstrength','admission-form','admission-form/create','admission-form/*/preview','admission-form/*/edit']) }}">
                           <a href="{{url('admission-formm')}}">Admission Forms</a>
                     </li>
                  @endif

                  @if( hasAccessToMenuOption(['ADMISSION-ENTRY','NEW-ADMISSION-ENTRY','CONSENTS','NEW-CONSENT-ENTRY']) )
                     <li class="{{ checkActive(['admission-entries','adm-entries','adm-entries/create','consents','consents/create']) }}">
                        <a href="{{url('admission-entries')}}">Admission Entries</a>
                     </li>
                  @endif

                  @if( hasAccessToMenuOption(['NEW-ADMISSION','ADMISSION-REGISTER','CENTRALIZED-STUDENT']) )
                     <li class="{{ checkActive(['admissions','admissions/create','admregister','centralized/students']) }}">
                        <a href="{{url('admissions')}}">Admissions</a>
                     </li>
                  @endif

                  @if( hasAccessToMenuOption(['HOSTEL-STUDENTS-LIST','HOSTEL-OUTSIDER-LIST','HOSTEL-OUTSIDER-LEDGER','HOSTEL-ADMISSION','HOSTEL-OUTSIDER-FORM','hostel-allocation','hostel-allocation-list','hostel-attendance','night-out-entry','night-out-return-entry']) )
                     <li class="{{ checkActive(['hostel-toolbar','hostels','hostels/outsiders','outsiders/ledger','hostels/create','hostels/outsiders/create','hostels-allocation','hostels-allocation/students','hostel-attendance','night-out/create','night-out-return']) }}">
                        <a href="{{url('hostel-toolbar')}}">Hostels</a>
                     </li>
                  @endif
               </ul>
            </li>

         <li class="{{ checkActive(['students-toolbar','idcard-report','student-category-wise-report','consolidated-student-list','students','stdledger','stdstrength','std-subjects','sub-stdstrength','rmvstudents/create','rmvstudents','student-feedback-report']) }}">
            @if(Gate::check('STUDENT-LIST') || Gate::check('STUDENT-LEDGER') || Gate::check('STUDENT-STRENGTH') || Gate::check('STUDENT-SUBJECTS') || Gate::check('SUBJECT-WISE-STRENGTH') || Gate::check('REMOVE-STUDENT') || Gate::check('REMOVED-STUDENTS-LIST'))
               <a href="{{url('students-toolbar')}}">
                  <i class="sidebar-item-icon ft-mail"></i><span class="nav-label">Students</span>
               </a>
            @endif
         </li>
         
         <li>
            <a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Fee Administration</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
               @if( hasAccessToMenuOption(['FEE-STRUCTURE','SUBJECT-CHARGES','INSTALLMENTS','FEEHEADS','CONCESSIONS','SUBHEAD-FEE-STRUCTURE','COPY-FEE-STRUCTURE']) )
                  <li class = "{{ checkActive(['maintanence-toolbar','feestructure','subcharges','installments','feeheads','concessions','feestructure/subheads','feestructure/copy']) }}"><a href="{{url('maintanence-toolbar')}}">Maintenance</a></li>
               @endif
               @if( hasAccessToMenuOption(['FEE-COLLECTION','FUND-WISE-COLLECTION','SW-FEE-DETAILS','PENDING-BALANCE','FUND-WISE-BALANCE','CONCESSION-REPORT']) )
                  <li class = "{{ checkActive(['feecollections','col-balance-toolbar','fundwise-collection','stdwise-feedetails','pendbalance','fundbalance','concess-report']) }}">
                     <a href="{{url('col-balance-toolbar')}}">Collection/Balance Reports</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['BILL-CANCELLATION','ONLINE-TRANSACTION-STATUS','FEE-INSTALLMENTS','HOSTEL-FEE-INSTALLMENTS','CENTERALIZED-FEE-INSTALLMENTS','STUDENT-SUBJECT-CHARGES','refund-requests-details']) )
                  <li class = "{{ checkActive(['bill-cancellation','bill/cancel','checktrans','fee-insts/create','host-fee-insts/create','cent-fee-insts/create','stdsubcharges','refund-requests-details']) }}">
                     <a href="{{url('bill-cancellation')}}">Std. Inst. Debit/Cancellation</a>
                  </li>
               @endif

               @if( hasAccessToMenuOption(['COLLEGE-RECEIPT','HOSTEL-RECEIPT','OUTSIDER-HOSTEL-RECEIPT','MISCELLANEOUS-INSTALLMENTS']) )
                  <li class = "{{ checkActive(['receipt-toolbar','receipts-college/create','receipts-hostel/create','receipts-outsider/create','misc-insts/create']) }}">
                     <a href="{{url('receipt-toolbar')}}">Receive Installment</a>
                  </li>
               @endif

               @if( hasAccessToMenuOption(['MISCELLANEOUS-DEBIT','MISCELLANEOUS-DEBIT-HOSTEL','MISCELLANEOUS-DEBIT-OUTSIDER']) )
                  <li class = "{{ checkActive(['misc-toolbar','misc-debit','misc-debit-hostel','misc-debit-outsider']) }}">
                     <a href="{{url('misc-toolbar')}}">Miscellaneous Debit</a>
                  </li>
               @endif

               @can('installment-debit-list')
               <li class = "{{ checkActive(['inst-debit']) }}">
                  <a href="{{url('inst-debit')}}">Installment Debit</a>
               </li>
               @endcan
               @if( Gate::check('prospectus-fees') || Gate::check('idcard-report') || Gate::check('daybook') || Gate::check('daybook2') || Gate::check('dbsummary') || Gate::check('feeheadwise-coll') || Gate::check('subheadwise-coll') || Gate::check('student-feedback-report') )
                  <li class = "{{ checkActive(['daybook-report','prospectus-fees','admission-form/payments','daybook','daybook2','dbsummary','feeheadwise-coll','subheadwise-coll']) }}">
                     <a href="{{ url('daybook-report') }}">Day Book Reports</a>
                  </li>
               @endif
            </ul>
         </li>

         @if( Gate::check('staff-list') || Gate::check('designation-list') || Gate::check('department-list') || Gate::check('faculty-list') )
            <li class="{{ checkActive(['staff-toolbar','staff','designation','department','faculty']) }}">
               
               <a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Staff</span><i class="arrow la la-angle-right"></i></a>
               <ul class="nav-2-level">
                  <li class="{{ checkActive(['staff-toolbar','staff-report-toolbar']) }}">
                        <a href="{{url('staff-toolbar')}}"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Staff</span></a>
                        <a href="{{url('staff-report-toolbar')}}"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Reports</span></a>

                  </li>
               </ul>
            </li>
         @endif

         @if( Gate::check('placement-companies') || Gate::check('placements') || Gate::check('placement-report'))
            <li class="{{ checkActive(['placement-toolbar','placement-report-toolbar']) }}">
               
               <a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Placements</span><i class="arrow la la-angle-right"></i></a>
               <ul class="nav-2-level">
                  <li class="{{ checkActive(['placement-toolbar','placement-report-toolbar']) }}">
                        <a href="{{url('placement-companies')}}"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Companies</span></a>
                        <a href="{{url('placements')}}"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Placements</span></a>
                        <a href="{{url('placement-report-toolbar')}}"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Reports</span></a>
                  </li>
               </ul>
            </li>
         @endif

         @if(Gate::check('SECTIONS-LIST') || Gate::check('SECTION-DETAIL') || Gate::check('SECTION-ALLOTMENT') || Gate::check('SUBJECT-WISE-STUDENT-STRENGTH') || Gate::check('ATTENDANCE') || Gate::check('DAILY-ATTENDANCE') || Gate::check('ATTENDANCE-REPORT') || Gate::check('STUDENT-MARKS') || Gate::check('MARKS-REPORT-CLASS-WISE') || Gate::check('MARKS-REPORT-STUDENT-WISE') || Gate::check('MARKS-REPORT-SUBJECT-WISE') || Gate::check('add-time-table') || Gate::check('add-time-table') )
            <li class="{{ checkActive(['academic-toolbar','section', 'subject-section', 'allot-section','stdsublist','attendance','daily-attendance','attendance-report','student-marks','marks-report/classwise','marks-report/student','marks-report/subjectwise','students-timetable','students-timetable/edit']) }}">
               <a href="{{ url('academic-toolbar')}}"><i class="sidebar-item-icon ft-grid"></i><span class="nav-label">Academics</span></a>
            </li>
         @endif

         @if(Gate::check('date-sheet-list') || Gate::check('exam-location-list') || Gate::check('seating-plan-list') || Gate::check('seating-plan-location') )
            <li class="{{ checkActive(['examination-toolbar','date-sheets','exam-locations','seating-plan-list','seating-plan-location']) }}">
               <a href="{{ url('examination-toolbar')}}"><i class="sidebar-item-icon ft-grid"></i><span class="nav-label">Examinations</span></a>
            </li>
         @endif

         <li>
            <a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Alumni</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
               @if( hasAccessToMenuOption(['ALUMNI-LIST','ALUMNI-EVENT-LIST']) )
                  <li class = "{{ checkActive(['alumnies-toolbar','alumnies','alumnies/event']) }}">
                     <a href="{{url('alumnies-toolbar')}}">Alumni List</a>
                  </li>
               @endif
                  @can('ADD-ALUMNI-EVENT') 
                     <li class = "{{ checkActive(['alumnies/meet']) }}">
                        <a href="{{url('/alumnies/meet')}}">Alumni Meet</a>
                     </li>
                  @endcan
                  @if( hasAccessToMenuOption(['alumni-sms-mail','send-regsms-alumni']) ) 
                     <li class = "{{ checkActive(['send-sms-alumni','sms-report']) }}">
                        <a href="{{url('sms-report')}}">SMS/Email</a>
                     </li>
                  @endcan
            </ul>
         </li>

         <li>
            <a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Inventory</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
               @if( hasAccessToMenuOption(['inv-item','add-inv-item','inv-item-category','inv-sub-item-category']) )
                  <li class = "{{ checkActive(['items-toolbar','items','items/create','item/*/edit', 'items_categories', 'items_categories/*/edit','items_sub_categories', 'items_sub_categories/*/edit']) }}">
                     <a href="{{url('items-toolbar')}}">Items</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['inv-vendor','add-inv-vendor']) )
                  <li class = "{{ checkActive(['vendors-toolbar','vendors','vendors/create','vendors/*/edit']) }}">
                     <a href="{{url('vendors')}}">Vendor</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['inv-purchase','add-inv-purchase']) )
                  <li class = "{{ checkActive(['purchases-toolbar','purchases','purchases/create','purchases/*/edit']) }}">
                     <a href="{{url('purchases')}}">Purchases</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['inv-issue','add-inv-issue']) )
                  <li class = "{{ checkActive(['issues-toolbar','issues','issues/create','issues/*/edit']) }}">
                     <a href="{{url('issues')}}">Issue</a>
                  </li>
               @endif
                  {{-- <li class = "{{ checkActive(['issues']) }}">
                  <a href="{{url('issues')}}">Issues</a>
                  </li> --}}
               @if( hasAccessToMenuOption(['inv-purchase-return','add-inv-purchase-return']) )
                  <li class = "{{ checkActive(['purchase-returns-toolbar','purchase-returns','purchase-returns/create','purchase-returns/*/edit']) }}">
                     <a href="{{url('purchase-returns')}}">Purchase Returns</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['inv-return','add-inv-return']) )
                  <li class = "{{ checkActive(['returns-toolbar','returns','returns/create','returns/*/edit']) }}">
                     <a href="{{url('returns')}}">Returns</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['inv-damage','add-inv-damage']) )
                  <li class = "{{ checkActive(['damages-toolbar','damages','damages/create','damages/*/edit']) }}">
                     <a href="{{url('damages')}}">Damages</a>
                  </li>
               @endif
               @if( hasAccessToMenuOption(['opening-stocks','add-opening-stocks']) )
                  <li class = "{{ checkActive(['opening-stocks-toolbar','opening-stocks','opening-stocks/create']) }}">
                     <a href="{{url('opening-stocks')}}">Opening Stock</a>
                  </li>
               @endif
               {{-- <li class = "{{ request()->is('stock-register' || 'long-term-asset') ? 'mm-active' : '' }}"> --}}
               <li class = "{{ checkActive(['stock-register','long-term-asset']) }}">
                  <a href="javascript:;" class = "">
                     <span class="nav-label">Reports</span>
                     <i class="arrow la la-angle-right"></i>
                  </a>
                  <ul class="nav-2-level">
                     @can('inv-stock-register')
                        <li class = "{{ checkActive(['stock-register']) }}">
                           <a href="{{url('stock-register')}}">Stock Register</a>
                        </li>
                     @endcan
                     @can('long-term-asset')
                        <li class = "{{ checkActive(['long-term-asset']) }}">
                           <a href="{{url('long-term-asset')}}">Long Term Asset</a>
                        </li>
                     @endcan

                     <li class = "{{ checkActive(['item-staff-loc-stock']) }}">
                           <a href="{{url('item-staff-loc-stock')}}">Item/Staff/Location Wise Stock Report</a>
                        </li>
                  </ul>
               </li>
            </ul>
         </li>
         @if(Gate::check('CATEGORIES') || Gate::check('RESERVED-CATEGORIES') || Gate::check('BOARD-UNIV') || Gate::check('COURSES') || Gate::check('SUBJECTS') || Gate::check('CITIES') || Gate::check('STATES') || Gate::check('LOCATION-LIST') || Gate::check('ALUMNI-EXPORT') || Gate::check('FEEDBACK-SECTIONS') || Gate::check('FEEDBACK-QUESTIONS') )
            <li class="{{ checkActive(['maintanence-toolbarr','categories','resvcategories','boards','courses','subjects','cities','states','locations','feedback-sections','feedback-questions']) }}">
               <a href="{{url('maintanence-toolbarr')}}"><i class="sidebar-item-icon ft-edit"></i><span class="nav-label">Maintanence</span></a>
            </li>
         @endif

         @if(Gate::check('MESSAGES') || Gate::check('MESSAGES-STAFF') )
            <li class="{{ checkActive(['messages','staffmsg','messages-toolbar']) }}">
               <a href="{{url('messages-toolbar')}}"><i class="sidebar-item-icon ft-edit"></i><span class="nav-label">Messaging(SMS/Email)</span></a>
            </li>
         @endif
         
         @can('nirf-report')
            <li class="{{ checkActive(['nirf-report']) }}">
               <a href="{{url('nirf-report')}}"><i class="sidebar-item-icon ft-edit"></i><span class="nav-label">NIRF Report</span></a>
            </li>
         @endcan
         @can('activity')
         <li>
            <a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Activity</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                  <li class = "{{ checkActive(['agency-types']) }}">
                     <a href="{{url('agency-types')}}">Organization/Sponsor/Activity</a>
                  </li>
                  <li class = "{{ checkActive(['orgnization']) }}">
                     <a href="{{url('orgnization')}}">Organization</a>
                  </li>
                  <li class = "{{ checkActive(['activities']) }}">
                     <a href="{{url('activities')}}">Activity</a>
                  </li>
            </ul>
         </li>
         @endcan
            <!-- <li class="{{ checkActive(['agency-types']) }}">
               <a href="{{url('agency-types')}}"><i class="sidebar-item-icon ft-edit"></i><span class="nav-label">Activity</span></a>
            </li> -->
        
         @can('USERS')
            <li class="{{ checkActive(['users-toolbar','users','roles','groups','permissions']) }}">
               <a href="{{url('users-toolbar')}}"><i class="sidebar-item-icon ft-edit"></i><span class="nav-label">Users & Rights</span></a>
            </li>
         @endcan
      </ul>
   </div>
@endif