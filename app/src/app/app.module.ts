import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AuthComponent } from './pages/auth/auth.component';
import { HomeComponent } from './pages/home/home.component';
import { LandingComponent } from './pages/landing/landing.component';
import { FormsModule, NgForm, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { RegisterComponent } from './pages/register/register.component';
import { FollowingCardComponent } from './components/following-card/following-card.component';
import { TrendComponent } from './components/trend/trend.component';
import { ImageSVGComponent } from './components/svg/image-svg/image-svg.component';
import { SmileSVGComponent } from './components/svg/smile-svg/smile-svg.component';
import { GifSVGComponent } from './components/svg/gif-svg/gif-svg.component';
import { UbicationSVGComponent } from './components/svg/ubication-svg/ubication-svg.component';
import { StatsSVGComponent } from './components/svg/stats-svg/stats-svg.component';
import { SearchSVGComponent } from './components/svg/search-svg/search-svg.component';
import { StarSVGComponent } from './components/svg/star-svg/star-svg.component';
import { SettingsSVGComponent } from './components/svg/settings-svg/settings-svg.component';
import { ProfileSVGComponent } from './components/svg/profile-svg/profile-svg.component';

@NgModule({
  declarations: [
    AppComponent,
    AuthComponent,
    HomeComponent,
    LandingComponent,
    RegisterComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule,
    FollowingCardComponent,
    TrendComponent,
    ImageSVGComponent,
    SmileSVGComponent,
    GifSVGComponent,
    UbicationSVGComponent,
    StatsSVGComponent,
    SearchSVGComponent,
    StarSVGComponent,
    SettingsSVGComponent,
    ProfileSVGComponent,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
