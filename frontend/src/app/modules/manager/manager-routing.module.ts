import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ManagerPageComponent } from './pages/manager-page/manager-page.component';

const routes: Routes = [
  {
    path: '', //TODO: http://localhost:4200/auth/login
    component: ManagerPageComponent,
  },
  {
    path: '**',
    redirectTo: '/manager',
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ManagerRoutingModule {}
