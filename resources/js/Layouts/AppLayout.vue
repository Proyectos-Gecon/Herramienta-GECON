<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import MenuBar from '@/Components/customs/MenuBar.vue';
import sliderbar from '@/Components/customs/sliderbar.vue';
import SplitButton from 'primevue/splitbutton';
import Breadcrumb from 'primevue/breadcrumb';
import Menubar from 'primevue/menubar';
import { permisos } from '@/composable/Permisions.js'

	const can = (array) => {
		
		var {val} = permisos(array)
		return val
	}

	defineProps({
		title: String,
	});

	const showingNavigationDropdown = ref(false);

	const switchToTeam = (team) => {
		Inertia.put(route('current-team.update'), {
			team_id: team.id,
		}, {
			preserveState: false,
		});
	};

	const logout = () => {
		Inertia.post(route('logout'));
	};

	const items =  [
			{
				label: 'Inicio',
				icon: 'pi pi-home',
				url: route('login')
			},
			{
				label:'Divisiones',
				icon:'pi pi-fw pi-sitemap',
				visible: can(['read division']),
				command:	()=> {
					Inertia.get(route('divisiones.index'))
				}
				
			},
			{
				label:'Proyectos',
				icon: 'pi pi-book',
				visible: can(['read proyectos']),
				items: [
					{
						label: 'Lista de proyectos',
						icon: 'pi pi-book',
						visible: can(['read proyectos']),
						command:	()=> {
							Inertia.get(route('proyectos.index'))
						}
					},
					{
						label: 'Contratos',
						icon: 'pi pi-file-edit',
						visible: can(['read contratos']),
						command:	()=> {
							Inertia.get(route('contratos.index'))
						}
					},
					{
						label: 'Clases',
						icon: 'pi pi-sitemap',
						visible: can(['read clases']),
						command:	()=> {
							Inertia.get(route('clases.index'))
						}
					},
					{
						label: 'Clientes',
						icon: 'pi pi-id-card',
						command:	()=> {
							Inertia.get(route('clientes.index'))
						}
					},
				]
			},
			{
				label:'Presupuetos',
				icon:'pi pi-dollar',
				visible: can(['read division']),
				items: [
					{
						label:'Dashboard',
						visible: can(['read activos']),
						command: () => {
							Inertia.get(route('personal.dashboard'))
						}
					},
					{
						label:'Presupuestos vs Ejecutado',
						visible: can(['read activos']),
						command: () => {
							Inertia.get(route('presupuestos.index'))
						}
					},

				]
				
			},
			{
				label:'Personal',
				icon:'pi pi-fw pi-user',
				visible: Inertia.page.props.user.permisos.includes('read personal'),
				items:[
					{
						label:'Dashboard',
						visible: can(['read activos']),
						command: () => {
							Inertia.get(route('personal.dashboard'))
						}
					},
					{
						label:'Personal Activo',
						visible: can(['read activos']),
						command: () => {
							Inertia.get(route('personal.activos'))
						}
					},
					{
						label:'Mi personal',
						command: () => {
							Inertia.get(route('personal.index'))
						}
					},
					{
						label:'Parte',
						command: () => {
							Inertia.get(route('parte.create'))
						}

					},
					{
						label:'Parte Actual',
						command: () => {
							Inertia.get(route('parte.index'))
						}
					},
					{
						label:'Novedades',
						command: () => {
							Inertia.get(route('novedades.index'))
						}
					},
				]
			},
			{
				label:'Almacen',
				icon:'pi pi-fw pi-briefcase',
				visible: can(['read almacen','read categoria' ,'read equipos', 'read prestamos']),
				items:[
					{
						label:'Almacenes',
						icon:'pi pi-fw pi-building',
						visible: Inertia.page.props.user.permisos.includes('read almacen'),
						command:	()=> {
							Inertia.get(route('almacens.index'))
						}
					},
					{
						label:'Categorias',
						icon:'pi pi-fw pi-sitemap',
						visible: can(['read categoria']),
						command:	()=> {
							Inertia.get(route('categorias.index'))
						}
					},
					{
						label:'Equipos',
						icon:'pi pi-fw pi-box',
						visible: can(['read equipos']),
						items:[
							{
								label:'Herramientas',
								icon:'pi pi-fw pi-briefcase',
								command:	()=> {
								Inertia.get(route('equipos.index'))
							}
							},
							{
								label:'Equipos Criticos',
								icon:'pi pi-fw pi-exclamation-triangle'
							}
						]
					},
					{
						label:'Asignaciones',
						icon:'pi pi-fw pi-user-plus',
						visible: can(['read prestamos']),
					},
				]
			},
			{
				label:'Seguridad',
				icon:'pi pi-fw pi-key',
				visible: Inertia.page.props.user.roles.includes('ADMIN'),
				items:[
					{
						label:'Roles',
						icon:'pi pi-fw pi-id-card',
						command: () => {
							Inertia.get(route('roles.index'))
						}
					},
					{
						label:'Permisos',
						icon:'pi pi-fw pi-lock',
						command: () => {
							Inertia.get(route('permisos.index'))
						}
					},
					{
						label:'Usuarios',
						icon:'pi pi-fw pi-users',
						command: () => {
							Inertia.get(route('users.index'))
						}
					}
				]
			},
	]

	const userOptions = [
		{
			label: 'Perfil',
			icon: 'pi pi-home',
			command: () => Inertia.get(route('teams.show', Inertia.page.props.user.current_team))
		},
		{
			label:'Salir',
			icon:'pi pi-fw pi-power-off',
			command: () => logout()
		}
	]

</script>

<template>
    <div>
        
        <Banner />

        <div class="min-h-screen bg-gray-100">
			<Menubar :model="items" >
				<template #end>
					<SplitButton :label="$page.props.user.name" :model="userOptions" class="p-button-text mb-2"></SplitButton>
				</template>
			</Menubar>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
