import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccesibilityComponent } from './pages/accesibility/accesibility.component';

const routes: Routes = [
  {
    path: '',
    component: AccesibilityComponent,
  },
  {
    path: '**',
    redirectTo: '/accesibility',
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AccesibilityRoutingModule {}
