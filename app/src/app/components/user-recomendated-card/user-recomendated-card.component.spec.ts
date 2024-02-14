import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserRecomendatedCardComponent } from './user-recomendated-card.component';

describe('UserRecomendatedCardComponent', () => {
  let component: UserRecomendatedCardComponent;
  let fixture: ComponentFixture<UserRecomendatedCardComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [UserRecomendatedCardComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(UserRecomendatedCardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
