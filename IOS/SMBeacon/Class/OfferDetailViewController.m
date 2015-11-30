//
//  OfferDetailViewController.m
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import "OfferDetailViewController.h"
#import "Global.h"

#import <AFNetworking.h>
#import <Haneke.h>
#import "URBAlertView.h"

#import "UIViewController+MJPopupViewController.h"
#import "PhotoViewDialog.h"


@interface OfferDetailViewController()<PhotoViewDialogDelegate>
{
    
    IBOutlet UIImageView *ivPic;
    IBOutlet UIActivityIndicatorView *loadingView;
    IBOutlet UILabel *lbTitle;
    IBOutlet UILabel *lbDescription;
    IBOutlet UILabel *lbOriginPrice;
    IBOutlet UILabel *lbOfferPrice;
    IBOutlet UILabel *lbOfferLimit;

    IBOutlet UILabel *lbMerchantName;

    IBOutlet UIButton *btnOffer;
    IBOutlet UIButton *btnClose;
    
    OFFERSTATUS m_offerStatus;
    
    NSTimer* mTimer;
    
    
    PhotoViewDialog * dialogPhoto;
}

@end

@implementation OfferDetailViewController

- (void) viewDidLoad {
    [super viewDidLoad];
    
//    UIImage *image = [UIImage imageNamed:@"background.png"];
//    self.view.backgroundColor = [UIColor colorWithPatternImage:image];
    self.view.backgroundColor = [UIColor whiteColor];

    loadingView.hidden = NO;
    NSString* imgUrl =_offerData[@"offer"][@"offerPicture"];
    [ivPic hnk_setImageFromURL:[NSURL URLWithString:imgUrl] placeholder:nil success:^(UIImage *image) {
        loadingView.hidden = YES;
        ivPic.image = image;
    } failure:^(NSError *error) {
        
    }];

    
    ivPic.contentMode = UIViewContentModeScaleAspectFill;
    ivPic.clipsToBounds = YES;
    ivPic.userInteractionEnabled =YES;
    [ivPic addGestureRecognizer:[[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(onTapPhoto:)]];
    
    
    lbTitle.text = _offerData[@"offer"][@"offerTitle"];
    lbDescription.text = _offerData[@"offer"][@"offerDescription"];
    lbOriginPrice.text = [NSString stringWithFormat:@"$ %@", _offerData[@"offer"][@"offerOriginalPrice"]];
    lbOfferPrice.text = [NSString stringWithFormat:@"$ %@", _offerData[@"offer"][@"offerOfferPrice"]];
    
//    lbOfferLimit.text = [self getLeftTime:_offerData[@"offer"][@"offerTimeLimit"]];
    [self discountTime];
    
    lbMerchantName.text = _offerData[@"merchant"][@"merchantName"];
    
    [self refreshButtonUI];
 
    
    OFFERSTATUS status;
    @try {
        status = [_offerData[@"offer"][@"offerStatus"] intValue];
    }
    @catch (NSException *exception) {
        status = OFFER_NONE;
    }
    @finally {
        
    }
    
    if (status == OFFER_ACCEPTED) {
        [self startCountTime];
    }
}

- (void) startCountTime
{
    if (mTimer == nil) {
        mTimer = [NSTimer scheduledTimerWithTimeInterval:1 target:self selector:@selector(discountTime) userInfo:nil repeats:YES];
    }
}
- (void) discountTime
{
    /*
       Timer refresh
     */
    OFFERSTATUS status;
    @try {
        status = [_offerData[@"offer"][@"offerStatus"] intValue];
    }
    @catch (NSException *exception) {
        status = OFFER_NONE;
    }
    @finally {
        
    }
    
    if (status == OFFER_REDEEMED) {
        lbOfferLimit.text = [NSString stringWithFormat:@"PLEASE SHOW MERCHANT\nOffer Code: %@", _offerData[@"offer"][@"offerCode"]] ;
        lbOfferLimit.lineBreakMode = NSLineBreakByWordWrapping;
        lbOfferLimit.numberOfLines = 0;
    }
    else if (status == OFFER_ACCEPTED){
        lbOfferLimit.text = [self getLeftTime:_offerData[@"offer"][@"offer_start_time"] timelimit:[_offerData[@"offer"][@"offerTimeLimit"] integerValue]];
    }
    else {
        lbOfferLimit.text = @"";
    }
    
}

- (NSString*) getLeftTime:(NSString* ) strStartTime timelimit:(NSInteger) limit
{
    NSDateFormatter *f = [[NSDateFormatter alloc] init];
    [f setDateFormat:@"yyyy-MM-dd HH:mm:ss"];
    NSDate *startDate = [f dateFromString:strStartTime];
    
    NSDate *limitDate = [startDate dateByAddingTimeInterval:limit*60*60];
    
    NSTimeInterval distanceBetweenDates = [limitDate timeIntervalSinceDate:[NSDate date]];

    int SECONDS = 60;
    int SECONDS_IN_HOUR = 60*SECONDS;
    int SECONDS_IN_DAY = 24*SECONDS_IN_HOUR;
    
    int days = distanceBetweenDates / SECONDS_IN_DAY;
    int hours = ((int)distanceBetweenDates % SECONDS_IN_DAY) / SECONDS_IN_HOUR;
    int minutes = ((int)distanceBetweenDates % SECONDS_IN_HOUR) / SECONDS;

    NSString *result = @"";
    if (days > 0) {
        result = [result stringByAppendingString:[NSString stringWithFormat:@"%d days", days]];
    }
    if (hours > 0) {
        result = [result stringByAppendingString:[NSString stringWithFormat:@" %d hours", hours]];
    }
    if (minutes > 0) {
        result = [result stringByAppendingString:[NSString stringWithFormat:@" %d minutes left", minutes]];
    }
    if (days <= 0 && hours <= 0 && minutes <= 0) {
        return @"Expired";
    }
    
    return result;
}

- (void) refreshButtonUI
{
    NSLog(@"offer data = %@", _offerData[@"offer"]);
    
    OFFERSTATUS status;
    @try {
        status = [_offerData[@"offer"][@"offerStatus"] intValue];
    }
    @catch (NSException *exception) {
        status = OFFER_NONE;
    }
    @finally {
        
    }
    
    lbOfferLimit.hidden = NO;
    if (status == OFFER_NONE) {
        [btnOffer setTitle:@"SAVE OFFER" forState:UIControlStateNormal];
        [btnClose setTitle:@"SKIP" forState:UIControlStateNormal];
        
        lbOfferLimit.hidden = YES;
    }
    else if (status == OFFER_ACCEPTED) {
        [btnOffer setTitle:@"REDEEM" forState:UIControlStateNormal];
        [btnClose setTitle:@"CLOSE" forState:UIControlStateNormal];
        //        0 = “Unknown”
        //        1 = “Immediate”
        //        2 = “Near”
        //        3 = “Far”
        
        NSString * proxStr = _offerData[@"beacon"][@"proximity_string"];
        if ([proxStr.uppercaseString isEqualToString:@"near".uppercaseString]
            || [proxStr.uppercaseString isEqualToString:@"immediate".uppercaseString]) {
            [btnOffer setEnabled:YES];
        }
        else {
            [btnOffer setEnabled:NO];
        }
    }
    else if (status == OFFER_REDEEMED) {
        btnOffer.hidden = YES;
        [btnClose setTitle:@"CLOSE" forState:UIControlStateNormal];
    }
    else { //redeem
        
    }
}
- (IBAction)onClickClose:(id)sender {
    
    [self dismissViewControllerAnimated:YES completion:^{
        
    }];
}
- (IBAction)onClickOffer:(id)sender {
    
    OFFERSTATUS status;
    @try {
        status = [_offerData[@"offer"][@"offerStatus"] intValue];
    }
    @catch (NSException *exception) {
        status = OFFER_NONE;
    }
    @finally {
        
    }
    
    
    if (status == OFFER_NONE) {
        // save offer
        NSMutableDictionary * offer = [[NSMutableDictionary alloc] initWithDictionary:_offerData[@"offer"]];
        [offer setObject:[NSNumber numberWithInt:OFFER_ACCEPTED] forKey:@"offerStatus"];
        
        NSDateFormatter *f = [[NSDateFormatter alloc] init];
        [f setDateFormat:@"yyyy-MM-dd HH:mm:ss"];
        NSString *startDate = [f stringFromDate:[NSDate date]];
        [offer setObject:startDate forKey:@"offer_start_time"];
        
        [_offerData setObject:offer forKey:@"offer"];
        
        [self startCountTime];
        
        NSMutableArray * allOffer = [[NSMutableArray alloc] initWithArray:[Global loadOfferList]];
        if (allOffer == nil) {
            allOffer = [[NSMutableArray alloc] init];
        }
        [allOffer addObject:_offerData];
        
        
        [Global saveOfferList:allOffer];
        
    }
    else if (status == OFFER_ACCEPTED) {

        if ([lbOfferLimit.text isEqualToString:@"Expired"]) {
            
            URBAlertView *alertView = [[URBAlertView alloc] initWithTitle:@"EXPIRED"
                                                                  message:@"This offer was expired."
                                                        cancelButtonTitle:@"OK"
                                                        otherButtonTitles:nil, nil];
            [alertView setHandlerBlock:^(NSInteger buttonIndex, URBAlertView *alertView) {
                [alertView hideWithCompletionBlock:^{
                    
                }];
            }];
            [alertView show];
            
            return;
        }
        
        
        NSMutableDictionary * offer = [[NSMutableDictionary alloc] initWithDictionary:_offerData[@"offer"]];
        [offer setObject:[NSNumber numberWithInt:OFFER_REDEEMED] forKey:@"offerStatus"];
        [_offerData setObject:offer forKey:@"offer"];

        NSMutableArray * allOffer = [[NSMutableArray alloc] initWithArray:[Global loadOfferList]];
        if (allOffer == nil) {
            allOffer = [[NSMutableArray alloc] init];
            [allOffer addObject:_offerData];
        }
        else {
            int index = 0;
            for (NSDictionary* dic in allOffer) {
                if ([dic[@"offer"][@"offerID"] isEqualToString:_offerData[@"offer"][@"offerID"]]) {
                    break;
                }
                index ++;
            }
            [allOffer replaceObjectAtIndex:index withObject:_offerData];
        }
        
        [Global saveOfferList:allOffer];
    }
//    else if (status == OFFER_REDEEM) {
//        NSMutableDictionary * offer = [[NSMutableDictionary alloc] initWithDictionary:_offerData[@"offer"]];
//        [offer setObject:[NSNumber numberWithInt:OFFER_REDEEMED] forKey:@"offerStatus"];
//        [_offerData setObject:offer forKey:@"offer"];
//
//        
//        NSMutableArray * allOffer = [[NSMutableArray alloc] initWithArray:[Global loadOfferList]];
//        if (allOffer == nil) {
//            allOffer = [[NSMutableArray alloc] init];
//            [allOffer addObject:_offerData];
//        }
//        else {
//            int index = 0;
//            for (NSDictionary* dic in allOffer) {
//                if ([dic[@"offer"][@"offerID"] isEqualToString:_offerData[@"offer"][@"offerID"]]) {
//                    break;
//                }
//                index ++;
//            }
//            [allOffer replaceObjectAtIndex:index withObject:_offerData];
//        }
//        
//        [Global saveOfferList:allOffer];
//    }
    else if (status == OFFER_REDEEMED) {
//        [self onClickClose:nil];
    }

    // change UI
    [self refreshButtonUI];
    
    
}

- (void) onTapPhoto:(UIGestureRecognizer*) gesture
{
    
    dialogPhoto = (PhotoViewDialog*)[self.storyboard instantiateViewControllerWithIdentifier:@"PhotoViewDialog"]; //[[PhotoViewDialog alloc] initWithNibName:@"PhotoViewDialog" bundle:nil];
    dialogPhoto.imgUrl = _offerData[@"offer"][@"offerPicture"];
    dialogPhoto.delegate = self;
    [self presentPopupViewController:dialogPhoto animationType:MJPopupViewAnimationFade];
}

- (void) closeDialog
{
    [self dismissPopupViewControllerWithanimationType:MJPopupViewAnimationFade];
//    dialogPhoto = nil;
}

#pragma - UI buiding
- (void)onClickRegister:(id)sender {
    int selectedIndexBeaconType = 0;
    NSString * beaconUDID = @"beacon ID";
    if (beaconUDID.length < 1) {
        return;
    }
    if (selectedIndexBeaconType == -1) {
        return;
    }
    
    
    NSString *requestUrl = [[NSString stringWithFormat:@"%@/RegisterNeewBeacon.aspx?BeaconUDID=%@",
                             SERVER_URL,
                             beaconUDID ]
                            stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
    
    NSLog(@"request = %@", requestUrl);
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    manager.responseSerializer = [AFHTTPResponseSerializer serializer];
    
    [manager GET:requestUrl
      parameters:nil
         success:^(AFHTTPRequestOperation *operation, id responseObject) {
             
             NSString *responseString = [[NSString alloc] initWithData:responseObject encoding:NSUTF8StringEncoding];
             
             NSLog(@"response = %@", responseString);
             
         }
         failure:^(AFHTTPRequestOperation *operation, NSError *error) {

         }];
}

int selectedIndexBeaconType = 0;

- (void) getBeaconTypeList
{
    NSArray * arrayBeaconType = nil;
    NSDictionary * beaconData = nil;

    
    if (arrayBeaconType == NULL) {
        
        NSString *requestUrl = [[NSString stringWithFormat:@"%@/GetAllBeaconTypes.aspx?guid=%@",
                                 SERVER_URL,
                                 arrayBeaconType] stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
        
        NSLog(@"request = %@", requestUrl);
        
        AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
        manager.responseSerializer = [AFHTTPResponseSerializer serializer];
        
        [manager GET:requestUrl
          parameters:nil
             success:^(AFHTTPRequestOperation *operation, id responseObject) {
                 
                 NSString *responseString = [[NSString alloc] initWithData:responseObject encoding:NSUTF8StringEncoding];
                 
                 NSLog(@"response = %@", responseString);
                 
                 int selectedIndexBeaconType = 0;
                 
                 if (beaconData != NULL) {
                     selectedIndexBeaconType = 12; //[beaconData[@"BeaconTypeID"] intValue];
                     if (selectedIndexBeaconType != -1) {
                         lbDescription.text = arrayBeaconType[selectedIndexBeaconType][@"BeaconTypeName"];
                     }
                 }
             }
             failure:^(AFHTTPRequestOperation *operation, NSError *error) {

             }];
    }
}

BOOL m_isShowPicker = false;

- (void)showPicker {
    if (m_isShowPicker) {
        return;
    }
    
    [UIView animateWithDuration:1.0
                     animations:^{
                         
                     }
                     completion:^(BOOL finished){
                         m_isShowPicker = YES;
                         
                         
                         if (selectedIndexBeaconType == -1) {
                             selectedIndexBeaconType = 0;
                         }
                         
                         if (selectedIndexBeaconType != -1) {
                             NSArray* arrayBeaconType = nil;
                             lbOfferLimit.text = arrayBeaconType[selectedIndexBeaconType][@"BeaconTypeName"];
                             
                             
                         }
                     }];
}
- (void)hidePicker {
    if (!m_isShowPicker) {
        return;
    }
    
    [UIView animateWithDuration:1.0
                     animations:^{
                         
                     }
                     completion:^(BOOL finished){
                         m_isShowPicker = NO;
                     }];
}

#pragma mark -
- (BOOL)textFieldShouldBeginEditing:(UITextField *)textField
{
    BOOL shouldEdit = YES;
    
    if ([textField isEqual:lbOfferLimit]) {
        
        
        shouldEdit = NO;
        
        [self getBeaconTypeList];
    }
    else {
        
        [self hidePicker];
    }
    
    return shouldEdit;
}

#pragma mark - ShoppingPicker View Delegate & DataSource Methods

- (NSInteger)numberOfComponentsInPickerView:(__unused UIPickerView *)pickerView
{
    return 1;
}

- (NSInteger)pickerView:(__unused UIPickerView *)pickerView numberOfRowsInComponent:(__unused NSInteger)component
{
    NSArray* arrayBeaconType = nil;
    
    if (arrayBeaconType == NULL) {
        return 0;
    }
    return arrayBeaconType.count;
}

- (NSString*)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component {
    NSArray* arrayBeaconType = nil;
    NSString * title = arrayBeaconType[row][@"BeaconTypeName"];
    return title;
}
- (void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component {
    selectedIndexBeaconType = (int)row;

}

#pragma mark keyboard
- (void) hideKeyboard :(UIGestureRecognizer*) gesture{
    
    if (m_isShowPicker) {
        [self hidePicker];
    }
}
@end
