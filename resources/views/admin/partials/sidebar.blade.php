
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
		     <?php 
			    // if(isset($_SESSION['firstname'])){
				// 	echo $_SESSION['firstname'].' '.$_SESSION['lastname'];
				// }else{
				// 	echo 'Admin';
				// }
			 ?>
		  </a>
		</div>
	  </div>

	  <!-- Sidebar Menu -->
	  <nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item has-treeview menu-open">
				<a href="" class="nav-link active">
				  <i class="nav-icon fas fa-tachometer-alt"></i>
				  <p>Dashboard</p>
				</a>
			</li>
			<!--END OF DASHBOARD-->

		  <!-- PRODUCTS START -->
		  
		  <li class="nav-item has-treeview">
			<a href="#" class="nav-link">
			  <i class="nav-icon fas fa-cubes"></i>
			  <p>
				Products
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
				  <p>Product List</p>
				</a>
				
			  </li>
			   <li class="nav-item">
				
				<a href="#" class="nav-link">
				  <i class="fas fa-angle-right nav-icon"></i>
				  <span class="badge badge-info right">
				     0
				  </span>
				  <p>Category</p>
				</a>
				
			  </li>
			  <li class="nav-item">
				
				<a href="#" class="nav-link">
				  <i class="fas fa-angle-right nav-icon"></i>
				  <span class="badge badge-info right">
				     0
				  </span>
				  <p>Supplies</p>
				</a>
				
			  </li>
			  
			</ul>
		  </li>
		  
		  <!-- PRODUCTS END -->

		</ul>
	  </nav>
	  <!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
  </aside>
  <!-- /Main Sidebar Container -->
  