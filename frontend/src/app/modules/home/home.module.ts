import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HomeRoutingModule } from './home-routing.module';
import { TweetsSectionComponent } from '@shared/components/tweets-section/tweets-section.component';

@NgModule({
  declarations: [],
  imports: [CommonModule, HomeRoutingModule, TweetsSectionComponent],
})
export class HomeModule {}
