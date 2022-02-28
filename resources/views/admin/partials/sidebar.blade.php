
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
		  <img src="{{ asset('assets/dist/img/img-profile.png') }}" class="img-circle elevation-2" alt="User Image">
		</div>
		<div class="info">
		  <a href="#" class="d-block">
		    {{ Auth::user()->ftname }} {{ Auth::user()->ltname }}
		  </a>
		</div>
	  </div>

	  <!-- Sidebar Menu -->
	  <nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<!--START OF DASHBOARD-->
			<li class="nav-item has-treeview menu-open">
				<a href="" class="nav-link active">
				  <i class="nav-icon fas fa-tachometer-alt"></i>
				  <p>Dashboard</p>
				</a>
			</li>
			<!--END OF DASHBOARD-->

			<!-- OFFICES START -->
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
			<!-- OFFICES END -->

			<!-- TRANSACTIONS START -->
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
						<i class="fas fa-minus nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Credit</p>
						</a>
						
					</li>
					<li class="nav-item">
						
						<a href="#" class="nav-link">
						<i class="fas fa-plus nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Debit</p>
						</a>
						
					</li>

					<li class="nav-item">
						
						<a href="#" class="nav-link">
						<i class="fas fa-file nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Summary</p>
						</a>
						
					</li>
				</ul>
			</li>
			<!-- TRANSACTIONS END -->

			<!-- USERS START -->
			<li class="nav-item has-treeview">
				<a href="{{ route('admin.roles') }}" class="nav-link">
				<i class="nav-icon fas fa-users"></i>
				<p>
					User Management
					<i class="fas fa-angle-left right"></i>
				</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						
						<a href="{{ route('admin.users') }}" class="nav-link">
							<i class="fas fa-angle-right nav-icon"></i>
							<span class="badge badge-info right">
								0
							</span>
							<p>Staff Accounts</p>
						</a>
						
					</li>
					<li class="nav-item">
						
						<a href="{{ route('admin.roles') }}" class="nav-link">
							<i class="fas fa-angle-right nav-icon"></i>
							<span class="badge badge-info right">
								0
							</span>
							<p>Staff Roles</p>
						</a>
						
					</li>
				</ul>
			</li>
			<!-- USERS END -->

			<!-- REPORTS START -->
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
						
						<a href="" class="nav-link">
						<i class="fas fa-angle-right nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Transactions</p>
						</a>
						
					</li>
					<li class="nav-item">
						
						<a href="#" class="nav-link">
						<i class="fas fa-angle-right nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Expenses</p>
						</a>
						
					</li>
				</ul>
			</li>
			<!-- REPORTS END -->

			<!-- SETTINGS START -->
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
						
						<a href="" class="nav-link">
						<i class="fas fa-angle-right nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Access Modules</p>
						</a>
						
					</li>
					<li class="nav-item">
						
						<a href="#" class="nav-link">
						<i class="fas fa-angle-right nav-icon"></i>
						<span class="badge badge-info right">
							0
						</span>
						<p>Pages</p>
						</a>
						
					</li>
				</ul>
			</li>
			<!-- SETTINGS END -->

		</ul>
	  </nav>
	  <!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
  </aside>
  <!-- /Main Sidebar Container -->
  