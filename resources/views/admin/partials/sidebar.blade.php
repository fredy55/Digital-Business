
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('admin.dashboard') }}" class="brand-link">
	  <img src="{{ asset('assets/images/logo_white.png') }}" alt="Admin Logo" class="brand-image"/>
	  <span class="brand-text font-weight-light">&nbsp;</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
	  <!-- Sidebar user panel (optional) -->
	  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
		  <img src="{{ asset('assets/dist/img/img-profile.png') }}" style="width: 50px;" class="img-circle elevation-2" alt="User Image">
		</div>
		<div class="info">
		  <a href="#" class="d-block">
		    {{ Auth::user()->ftname }} {{ Auth::user()->ltname }} <br />
			<span style="font-size: 14px;">({{ findRole() }})</span>
		  </a>
		</div>
	  </div>

	  <!-- Sidebar Menu -->
	  <nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<!--START OF DASHBOARD-->
			<li class="nav-item has-treeview menu-open">
				<a href="{{ route('admin.dashboard') }}" class="nav-link active">
				  <i class="nav-icon fas fa-tachometer-alt"></i>
				  <p>Dashboard</p>
				</a>
			</li>
			<!--END OF DASHBOARD-->

			<!-- TRANSACTIONS START -->
			@if (has_access_to(Auth::user()->role_id,3)==1)
				<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				<i class="nav-icon fas fa-credit-card"></i>
				<p>
					Transactions
					<i class="fas fa-angle-left right"></i>
				</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						
						<a href="{{ route('admin.transacts.credits') }}" class="nav-link">
						<i class="fas fa-plus nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Credit</p>
						</a>
						
					</li>
					<li class="nav-item">
						<a href="{{ route('admin.transacts.debits') }}" class="nav-link">
							<i class="fas fa-minus nav-icon"></i>
							<span class="badge badge-info right">
								0
							</span>
							<p>Debit</p>
						</a>
					</li>
				</ul>
			</li>
			@endif
			<!-- TRANSACTIONS END -->

			
			<!-- OFFICES START -->
			@if (has_access_to( Auth::user()->role_id,4))
			<li class="nav-item has-treeview">
				<a href="{{ route('admin.offices') }}" class="nav-link">
				  <i class="nav-icon fas fa-home"></i>
				  <p>
					Offices
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
				  
				  <li class="nav-item">
					<a href="{{ route('admin.offices') }}" class="nav-link">
					  <i class="fas fa-angle-right nav-icon"></i>
					  <span class="badge badge-info right">
						 0
					  </span>
					  <p>Branches</p>
					</a>
				  </li>
				  
				</ul>
			</li>
			@endif
			<!-- OFFICES END -->

			<!-- USERS START -->
			@if (has_access_to(Auth::user()->role_id,5)==1)
			<li class="nav-item has-treeview">
				<a href="{{ route('admin.users') }}" class="nav-link">
					<i class="fas fa-users nav-icon"></i>
					<span class="badge badge-info right">0</span>
					<p>Staff Accounts</p>
				</a>
			</li>
			@endif
			<!-- USERS END -->

			<!-- REPORTS START -->
			@if (has_access_to(Auth::user()->role_id,7)==1)
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				<i class="nav-icon fas fa-file"></i>
				<p>
					Reports
					<i class="fas fa-angle-left right"></i>
				</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{ route('admin.transacts.daily') }}" class="nav-link">
							<i class="fas fa-file nav-icon"></i>
							<span class="badge badge-info right">
								0
							</span>
							<p>Transaction List</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('admin.transacts.summary') }}" class="nav-link">
							<i class="fas fa-file nav-icon"></i>
							<span class="badge badge-info right">
								0
							</span>
							<p>Find Transaction</p>
						</a>
					</li>
				</ul>
			</li>
			@endif
			<!-- REPORTS END -->

			<!-- SETTINGS START -->
			@if (has_access_to(Auth::user()->role_id,6)==1)
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				<i class="nav-icon fas fa-cogs"></i>
				<p>
					Settings
					<i class="fas fa-angle-left right"></i>
				</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						
						<a href="{{ route('admin.roles') }}" class="nav-link">
							<i class="fas fa-handshake nav-icon"></i>
							<span class="badge badge-info right">
								0
							</span>
							<p>Staff Roles</p>
						</a>
						
					</li>
					<li class="nav-item">
						
						<a href="{{ route('admin.modules') }}" class="nav-link">
						<i class="fas fa-lock nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Access Modules</p>
						</a>
						
					</li>
				</ul>
			</li>
			@endif
			<!-- SETTINGS END -->

			<!-- LOGOUT START -->
			<li class="nav-item has-treeview">
				<a href="{{ route('admin.logout') }}" class="nav-link">
				  <i class="nav-icon fas fa-power-off"></i>
				  <p>Logout</p>
				</a>
			</li>

			{{-- <li class="nav-item has-treeview">
				<a href="{{ route('admin.restrict.denied') }}" class="nav-link">
				  <i class="nav-icon fas fa-lock"></i>
				  <p>Access Denied</p>
				</a>
			</li> --}}
			<!-- /LOGOUT END -->

		</ul>
	  </nav>
	  <!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
  </aside>
  <!-- /Main Sidebar Container -->
  