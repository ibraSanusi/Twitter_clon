import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BeaWhisperingComponent } from './bea-whispering.component';

describe('BeaWhisperingComponent', () => {
  let component: BeaWhisperingComponent;
  let fixture: ComponentFixture<BeaWhisperingComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BeaWhisperingComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(BeaWhisperingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
