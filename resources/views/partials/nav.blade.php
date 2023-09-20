@if(auth()->check())
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="{{ checkActive(['/']) }} treeview">
        <a href="{{url('/')}}">
          <img src="{{asset('dist/img/dashboard.png')}}"><span>Dashboard</span>
        </a>
      </li>

      <li class="treeview {{ checkActive(['admission-form','admission-form/create','admission-form/*/preview','admission-form/*/edit']) }}">
        <a href="{{url('/admission-form')}}"><img src="{{asset('dist/img/admission-forms.png')}}"><span>Admission Forms</span></a>
      </li>

      <li class="treeview {{ checkActive(['adm-entries']) }}">
        <a href="{{url('/adm-entries')}}"><img src="{{asset('dist/img/admissn-entries.png')}}"><span>Admission Entries</span></a>
      </li>

      <!--      <li class="treeview {{ checkActive(['adm-entries/create']) }}">
              <a href="{{url('/adm-entries/create')}}"><img src="{{asset('dist/img/admission.png')}}"><span>Entry For Admissions</span></a>
            </li>-->

      <li class="treeview {{ checkActive(['admissions','admissions/create','admissions/*/preview']) }}">
        <a href="{{url('/admissions/create')}}"><img src="{{asset('dist/img/admission.png')}}"><span>Admissions</span></a>
      </li>

      <li class="treeview {{ checkActive(['students','stdledger','stdstrength']) }}">
        <a href="{{url('/students')}}"><img src="{{asset('dist/img/student-list.png')}}"><span>Students</span></a>
      </li>

      <li class="treeview {{ checkActive(['hostels']) }}">
        <a href="{{url('/hostels')}}"><img src="{{asset('dist/img/hostel-admssn.png')}}"><span>Hostels</span></a>
      </li>

      <!--      <li class="treeview {{ checkActive(['hostels/create']) }}">
              <a href="{{url('/hostels/create')}}"><img src="{{asset('dist/img/hostel-admssn.png')}}"><span>Hostel Admission</span></a>
            </li>
            <li class="treeview {{ checkActive(['hostels/outsiders/create']) }}">
              <a href="{{url('/hostels/outsiders/create')}}"><img src="{{asset('dist/img/outsider-hostel.png')}}"><span>Outsider Hostel Admission</span></a>
            </li>-->

      
            
      <li class="treeview {{ checkActive(['feecollections','fundwise-collection','installments','installments/create','installments/*/edit','feeheads','feeheads/create','feeheads/*/edit','feeheads/*/subheads','subheads/*/edit','concessions','concessions/create','concessions/*/edit','feestructure','subcharges','subcharges/*/edit']) }}">
        <a href="#">
          <img src="{{asset('dist/img/fees.png')}}"><span>Fees</span>  <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        
        <ul class="treeview-menu">
          <li class = "{{ checkActive(['feestructure']) }}">
            <a href="{{url('/feestructure')}}"><img src="{{asset('dist/img/maintenance.png')}}"><span>Maintenance</span></a>
          </li>
          <li class = "{{ checkActive(['feecollections']) }}">
            <a href="{{url('/feecollections')}}"><img src="{{asset('dist/img/fee-collection.png')}}"><span>Reports</span></a>
          </li>
          <!--          <li class = "{{ checkActive(['subcharges','subcharges/*/edit']) }}">
                      <a href="{{url('/subcharges')}}"><img src="{{asset('dist/img/categories.png')}}"><span>Subject Charges</span></a>
                    </li>
                    <li class="{{ checkActive(['installments','installments/create','installments/*/edit']) }}">
                      <a href ="{{url('/installments')}}"><img src="{{asset('dist/img/installment.png')}}"><span> Installments</span></a>
                    </li>
                    <li class="{{ checkActive(['feeheads','feeheads/create','feeheads/*/edit','feeheads/*/subheads','subheads/*/edit']) }}">
                      <a href="{{url('/feeheads')}}"><img src="{{asset('dist/img/fee-heads.png')}}"> <span>Feeheads</span></a>
                    </li>
                    <li class="{{ checkActive(['concessions','concessions/create','concessions/*/edit']) }}">
                      <a href="{{url('/concessions')}}"><img src="{{asset('dist/img/concession.png')}}"><span> Concessions</span></a>
                    </li>-->
        </ul>
      </li>

      <li class="treeview {{ checkActive(['bill/cancel', 'checktrans', 'receipts-outsider/create','receipts-college/create','receipts-hostel/create','fee-insts/create','host-fee-insts/create']) }}">
        <a href="#">
          <img src="{{asset('dist/img/bill-recpt.png')}}"><span>Bills & Receipts</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
          <li class = "{{ checkActive(['bill/cancel']) }}">
            <a href="{{url('/bill/cancel')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Bill Cancellation</span></a>
          </li>
          <li class = "{{ checkActive(['checktrans']) }}">
            <a href="{{url('/checktrans')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Online Trn. Status</span></a>
          </li>
          <li class = "{{ checkActive(['receipts-college/create']) }}">
            <a href="{{url('/receipts-college/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Receipts</span></a>
          </li>
          <!--          <li class = "{{ checkActive(['receipts-hostel/create']) }}">
                      <a href="{{url('/receipts-hostel/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Hostel Receipts</span></a>
                    </li>
                    <li class = "{{ checkActive(['receipts-outsider/create']) }}">
                      <a href="{{url('/receipts-outsider/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Outsider Hostel Receipts</span></a>
                    </li>-->
          <li class = "{{ checkActive(['fee-insts/create']) }}">
            <a href="{{url('/fee-insts/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Fee Installments</span></a>
          </li>
          <li class = "{{ checkActive(['host-fee-insts/create']) }}">
            <a href="{{url('host-fee-insts/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Hostel Fee Inst</span></a>
          </li>
          <li class = "{{ checkActive(['cent-fee-insts/create']) }}">
            <a href="{{url('/cent-fee-insts/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Centeralized Installments</span></a>
          </li>
          <li class = "{{ checkActive(['stdsubcharges']) }}">
            <a href="{{url('stdsubcharges')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Subject Charges</span></a>
          </li>
          <li class = "{{ checkActive(['instdebits']) }}">
            <a href="{{url('inst-debit')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Installment Debit</span></a>
          </li>
          <li class = "{{ checkActive(['miscdebits']) }}">
            <a href="{{url('misc-debit')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Misc. Debit</span></a>
          </li>
        </ul>
      </li>

      <li class = "{{ checkActive(['staff']) }}">
        <a href="{{url('staff')}}"><img src="{{asset('dist/img/reports.png')}}"><span>Staff</span></a>
      </li>

      <li class = "{{ checkActive(['section', 'stdsublist', 'attendance']) }}">
        <a href="{{ url('allot-section')}}"><img src="{{asset('dist/img/reports.png')}}"><span>Academics</span></a>
      </li>
      <li class = "{{ checkActive(['date-sheets']) }}">
          <a href="{{ url('date-sheets')}}"><img src="{{asset('dist/img/reports.png')}}"><span>Examinations</span></a>
      </li>

       {{-- <li class="treeview {{ checkActive(['bill/cancel', 'checktrans', 'receipts-outsider/create','receipts-college/create','receipts-hostel/create','fee-insts/create']) }}">
        <a href="#">
          <img src="{{asset('dist/img/bill-recpt.png')}}"><span>Bills & Receipts</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
          <li class = "{{ checkActive(['bill/cancel']) }}">
            <a href="{{url('/bill/cancel')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Bill Cancellation</span></a>
          </li>
          <li class = "{{ checkActive(['checktrans']) }}">
            <a href="{{url('/checktrans')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Online Trn. Status</span></a>
          </li>
          <li class = "{{ checkActive(['receipts-college/create']) }}">
            <a href="{{url('/receipts-college/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Receipts</span></a>
          </li>
          <!--          <li class = "{{ checkActive(['receipts-hostel/create']) }}">
                      <a href="{{url('/receipts-hostel/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Hostel Receipts</span></a>
                    </li>
                    <li class = "{{ checkActive(['receipts-outsider/create']) }}">
                      <a href="{{url('/receipts-outsider/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Outsider Hostel Receipts</span></a>
                    </li>-->
          <li class = "{{ checkActive(['fee-insts/create']) }}">
            <a href="{{url('/fee-insts/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Fee Installments</span></a>
          </li>
          <li class = "{{ checkActive(['cent-fee-insts/create']) }}">
            <a href="{{url('/cent-fee-insts/create')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Centeralized Installments</span></a>
          </li>
          <li class = "{{ checkActive(['stdsubcharges']) }}">
            <a href="{{url('stdsubcharges')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Subject Charges</span></a>
          </li>
          <li class = "{{ checkActive(['instdebits']) }}">
            <a href="{{url('inst-debit')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Installment Debit</span></a>
          </li>
          <li class = "{{ checkActive(['miscdebits']) }}">
            <a href="{{url('misc-debit')}}"><img src="{{asset('dist/img/receipts.png')}}"><span>Misc. Debit</span></a>
          </li>
        </ul>
      </li> --}}

      @can('ALUMNI-LIST') 
      <li class="treeview {{ checkActive(['alumnies','alumnies/meet',]) }}">
        <a href="#">
          <img src="{{asset('dist/img/bill-recpt.png')}}"><span>Alumni</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
          <li class = "{{ checkActive(['alumnies']) }}">
            <a href="{{url('alumnies')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Alumni List</span></a>
          </li>
          @can('ADD-ALUMNI-EVENT') 
          <li class = "{{ checkActive(['alumnies/meet']) }}">
            <a href="{{url('/alumnies/meet')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Alumni Meet</span></a>
          </li>
          @endcan
          @can('alumni-sms-mail')
          <li class = "{{ checkActive(['send-sms-alumni']) }}">
            <a href="{{url('send-sms-alumni')}}"><img src="{{asset('dist/img/user-rights.png')}}"><span>Send SMS/Email</span></a>
          </li>
          @endcan
        </ul>
      </li>
      @endcan

      <li class = "{{ checkActive(['idcard-report']) }}">
        <a href="{{url('idcard-report')}}"><img src="{{asset('dist/img/reports.png')}}"><span>Reports</span></a>
      </li>

      <li class="treeview {{ checkActive(['items','opening-stocks','opening-stocks/create','opening-stocks/*/edit','items/create','item/*/edit', 'items_categories', 'items_categories/*/edit','items_sub_categories', 'items_sub_categories/*/edit',
        'vendors','vendors/create','vendors/*/edit','purchases','purchases/create','purchases/*/edit','issues','issues/create','issues/*/edit','purchase-returns','purchase-returns/create','purchase-returns/*/edit',
        'returns','returns/create','returns/*/edit','damages','damages/create','damages/*/edit','stock-register']) }}">
        <a href="#">
          <img src="{{asset('dist/img/bill-recpt.png')}}"><span>Inventory</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
          <li class = "{{ checkActive(['items','items/create','item/*/edit', 'items_categories', 'items_categories/*/edit','items_sub_categories', 'items_sub_categories/*/edit']) }}">
            <a href="{{url('items')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Items</span></a>
          </li>
          <li class = "{{ checkActive(['vendors','vendors/create','vendors/*/edit']) }}">
              <a href="{{url('vendors')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Vendor</span></a>
            </li>
          <li class = "{{ checkActive(['purchases','purchases/create','purchases/*/edit']) }}">
            <a href="{{url('purchases')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Purchases</span></a>
          </li>
          <li class = "{{ checkActive(['issues','issues/create','issues/*/edit']) }}">
            <a href="{{url('issues')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Issue</span></a>
          </li>
          {{-- <li class = "{{ checkActive(['issues']) }}">
            <a href="{{url('issues')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Issues</span></a>
          </li> --}}
          <li class = "{{ checkActive(['purchase-returns','purchase-returns/create','purchase-returns/*/edit']) }}">
            <a href="{{url('purchase-returns')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Purchase Returns</span></a>
          </li>
          <li class = "{{ checkActive(['returns','returns/create','returns/*/edit']) }}">
            <a href="{{url('returns')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Returns</span></a>
          </li>
          <li class = "{{ checkActive(['damages','damages/create','damages/*/edit']) }}">
            <a href="{{url('damages')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Damages</span></a>
          </li>
          <li class = "{{ checkActive(['stock-register']) }}">
            <a href="{{url('stock-register')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Stock Register</span></a>
          </li>
          @can('opening-stocks')
            <li class = "{{ checkActive(['opening-stocks']) }}">
              <a href="{{url('opening-stocks')}}"><img src="{{asset('dist/img/bill-cancel.png')}}"><span>Opening Stock</span></a>
            </li>
          @endcan
        </ul>
      </li>

      <!--      <li class="treeview {{ checkActive(['daybook','daybookII','feeheadwise-coll','subheadwise-coll','hostels/outsiders','hostels/outsiders/ledger','idcard-report']) }}">
                        <a href="#">
                          <img src="{{asset('dist/img/reports.png')}}"><span>Reports</span>
                        </a>
                        <ul class="treeview-menu">
                  <li class = "{{ checkActive(['prospectus-fees']) }}">
                    <a href="{{url('/prospectus-fees')}}"><img src="{{asset('dist/img/online-prosfees.png')}}"><span>Online Prospectus Fees</span></a>
                  </li>
                  <li class = "{{ checkActive(['students']) }}">
                    <a href="{{url('/students')}}"><img src="{{asset('dist/img/student-list.png')}}"><span>Students List</span></a>
                  </li>
                  <li class = "{{ checkActive(['stdledger']) }}">
                    <a href="{{url('/stdledger')}}"><img src="{{asset('dist/img/student-ledger.png')}}"><span>Student Ledger</span></a>
                  </li>
                  <li class = "{{ checkActive(['hostels/outsiders']) }}">
                    <a href="{{url('/hostels/outsiders')}}"><img src="{{asset('dist/img/outsider-list.png')}}"><span>Outsider List</span></a>
                  </li>
                  <li class = "{{ checkActive(['hostels/outsiders/ledger']) }}">
                    <a href="{{url('/hostels/outsiders/ledger')}}"><img src="{{asset('dist/img/outsider-ledger.png')}}"><span>Outsider Ledger</span></a>
                  </li>
                  <li class="{{ checkActive(['feecollections']) }}">
                    <a href ="{{url('/feecollections')}}"><img src="{{asset('dist/img/fee-collection.png')}}"><span>Fee Collection</span></a>
                  </li>
                  <li class="{{ checkActive(['fundwise-collection']) }}">
                    <a href ="{{url('/fundwise-collection')}}"><img src="{{asset('dist/img/installment.png')}}"><span>Fund Wise Collection</span></a>
                  </li>
                  <li class = "{{ checkActive(['stdstrength']) }}">
                    <a href="{{url('/stdstrength')}}"><img src="{{asset('dist/img/student-strength.png')}}"><span>Student Strength</span></a>
                  </li>
                  <li class = "{{ checkActive(['sub-stdstrength']) }}">
                    <a href="{{url('/sub-stdstrength')}}"><img src="{{asset('dist/img/fee-structure.png')}}"><span>SubjectWise StdStrength</span></a>
                  </li>
                  <li class = "{{ checkActive(['stdwise-feedetails']) }}">
                    <a href="{{url('/stdwise-feedetails')}}"><img src="{{asset('dist/img/sw-feedetails.png')}}"><span>SW Fee-Details</span></a>
                  </li>
                  <li class = "{{ checkActive(['admregister']) }}">
                    <a href="{{url('/admregister')}}"><img src="{{asset('dist/img/sw-feedetails.png')}}"><span>Admission Register</span></a>
                  </li>
                  <li class = "{{ checkActive(['pendbalance']) }}">
                    <a href="{{url('/pendbalance')}}"><img src="{{asset('dist/img/sw-feedetails.png')}}"><span>Pending Balance</span></a>
                  </li>
                  <li class = "{{ checkActive(['idcard-report']) }}">
                    <a href="{{url('/idcard-report')}}"><img src="{{asset('dist/img/sw-feedetails.png')}}"><span>ID Card Report</span></a>
                  </li>
                  <li class = "{{ checkActive(['concess-report']) }}">
                    <a href="{{url('/concess-report')}}"><img src="{{asset('dist/img/sw-feedetails.png')}}"><span>Student With Concession</span></a>
                  </li>
                  <li class="{{ checkActive(['daybook']) }}">
                    <a href ="{{url('/daybook')}}"><img src="{{asset('dist/img/daywise-collection.png')}}"><span>Day Book I</span></a>
                  </li>
                  <li class="{{ checkActive(['daybookII']) }}">
                    <a href ="{{url('/daybookII')}}"><img src="{{asset('dist/img/daywise-collection.png')}}"><span>Day Book II</span></a>
                  </li>
                  <li class="{{ checkActive(['feeheadwise-coll']) }}">
                    <a href ="{{url('/feeheadwise-coll')}}"><img src="{{asset('dist/img/daywise-collection.png')}}"><span>Feehead-Wise Collection</span></a>
                  </li>
                  <li class="{{ checkActive(['subheadwise-coll']) }}">
                    <a href ="{{url('/subheadwise-coll')}}"><img src="{{asset('dist/img/daywise-collection.png')}}"><span>Subhead-Wise Collection</span></a>
                  </li>
                </ul>
            </li>-->
      
      <li class="treeview {{ checkActive(['categories','feedback-sections','feedback-questions','export_to_alumni','categories/create','categories/*/edit','resvcategories','resvcategories/create','resvcategories/*/edit','boards','boards/create','locations',
                  'boards/*/edit','courses','courses/create','courses/*/edit','courses/*/subjects','courses/*/subgroup','courses/*/editgroup','courses/*/addsubject','courses/*/editsubject','subjects','subjects/create','subjects/*/edit','cities','cities/create','cities/*/edit','states','states/create','states/*/edit']) }}">
                  <a href="{{url('/categories')}}">
                    <img src="{{asset('dist/img/maintenance.png')}}"><span>Maintainance</span>
                  </a>
        <!--            <ul class="treeview-menu">
            <li class="{{ checkActive(['categories','categories/create','categories/*/edit']) }}">
              <a href="{{url('/categories')}}"><img src="{{asset('dist/img/categories.png')}}"> <span>Categories</span></a>
            </li>
            <li class="{{ checkActive(['resvcategories','resvcategories/create','resvcategories/*/edit']) }}">
              <a href="{{url('/resvcategories')}}"><img src="{{asset('dist/img/reserved-cate.png')}}"><span>Reserved Categories</span></a>
            </li>
            <li class="{{ checkActive(['boards','boards/create','boards/*/edit']) }}">
              <a href="{{url('/boards')}}"><img src="{{asset('dist/img/board-univ.png')}}"><span>Board/University</span></a>
            </li>
            <li class="{{ checkActive(['courses','courses/create','courses/*/edit','courses/*/subjects','courses/*/subgroup','courses/*/editgroup','courses/*/addsubject','courses/*/editsubject']) }}">
              <a href="{{url('/courses')}}"><img src="{{asset('dist/img/courses.png')}}"><span>Courses</span></a>
            </li>
            <li class="{{ checkActive(['subjects','subjects/create','subjects/*/edit']) }}">
              <a href="{{url('/subjects')}}"><img src="{{asset('dist/img/subjects.png')}}"><span>Subjects</span></a>
            </li>
            <li class="{{ checkActive(['cities','cities/create','cities/*/edit']) }}">
              <a href="{{url('/cities')}}"><img src="{{asset('dist/img/cities.png')}}"><span>Cities</span></a>
            </li>
            <li class="{{ checkActive(['states','states/create','states/*/edit']) }}">
              <a href="{{url('/states')}}"><img src="{{asset('dist/img/states.png')}}"><span>States</span></a>
            </li>
          </ul>-->
      </li>
      <!--      <li class="treeview {{ checkActive(['users','roles','permissions','groups','users/*/edit','roles/*/edit','roles/*/permissions','permissions/*/edit']) }}">
              <a href="#">
                <img src="{{asset('dist/img/user-rights.png')}}"><span>Users & Rights</span>
              </a>
              <ul class="treeview-menu">
                @can('USERS')
                <li class = "{{ checkActive(['users','users/*/edit']) }}">
                  <a href="{{url('/users')}}"><img src="{{asset('dist/img/users.png')}}"><span>Users</span></a>
                </li>
                @endcan
                <li class = "{{ checkActive(['groups','groups/*/edit','groups/*/permissions']) }}">
                  <a href="{{url('/groups')}}"><img src="{{asset('dist/img/groups.png')}}"><span>Groups</span></a>
                </li>
                @can('ROLES')
                <li class="{{ checkActive(['roles','roles/*/edit','roles/*/permissions']) }}">
                  <a href="{{url('/roles')}}"><img src="{{asset('dist/img/roles.png')}}"><span>Roles</span></a>
                </li>
                @endcan
                @can('PERMISSIONS')
                <li class="{{ checkActive(['permissions','permissions/*/edit']) }}">
                  <a href="{{url('/permissions')}}"><img src="{{asset('dist/img/permission.png')}}"><span>Permissions</span></a>
                </li>
                @endcan
              </ul>
            </li>-->
       <li class = "{{ checkActive(['messages']) }}">
        <a href="{{url('messages')}}"><img src="{{asset('dist/img/user-rights.png')}}"><span>Send SMS</span></a>
      </li>
      
      @can('USERS')
      <li class = "{{ checkActive(['users','roles','groups','permissions']) }}">
        <a href="{{url('/users')}}"><img src="{{asset('dist/img/user-rights.png')}}"><span>Users And Rights</span></a>
      </li>
      @endcan
      
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
@endif
