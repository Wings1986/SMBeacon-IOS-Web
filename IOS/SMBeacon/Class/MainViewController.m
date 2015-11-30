//
//  MainViewController.m
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import "MainViewController.h"
#import "OfferTableViewCell.h"
#import "OfferDetailViewController.h"

#import "Global.h"
#import "Haneke.h"

#import "AppDelegate.h"
#import "URBAlertView.h"


@interface MainViewController()<UITableViewDataSource, UITableViewDelegate>
{
    
    IBOutlet UITableView *mTableView;
    
    NSMutableArray * arrOfferList;
    
}

@end

@implementation MainViewController

- (void) viewDidLoad
{
    [super viewDidLoad];
    
//    UIImage *image = [UIImage imageNamed:@"background.png"];
//    self.view.backgroundColor = [UIColor colorWithPatternImage:image];
    self.view.backgroundColor = [UIColor whiteColor];
    
    // notification
    NSOperationQueue *mainQueue = [NSOperationQueue mainQueue];
    [[NSNotificationCenter defaultCenter] addObserverForName:@"notification_open_offer"
                                                      object:nil
                                                       queue:mainQueue
                                                  usingBlock:^(NSNotification *notification)
        {
            NSLog(@"Notification received!");
            
            NSLog(@"Notification found with:"
                  "\r\n     name:     %@"
                  "\r\n     object:   %@"
                  "\r\n     userInfo: %@",
                  [notification name],
                  [notification object],
                  [notification userInfo]);
            
            [self performSegueWithIdentifier:@"gotoOfferDetail" sender:[notification object]];
        }];
    
}
- (void) viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    NSArray * arry = [Global loadOfferList];
    if (arry != NULL) {
        arrOfferList = [[NSMutableArray alloc] initWithArray:arry];
    }
    
    [mTableView reloadData];
}

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([segue.identifier isEqualToString:@"gotoOfferDetail"]) {
        OfferDetailViewController *vc = segue.destinationViewController;
        vc.offerData = [[NSMutableDictionary alloc] initWithDictionary:(NSDictionary*) sender];
    }
}

#pragma mark - UITableView Delegate
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    if (arrOfferList == NULL) {
        return 0;
    }

    return arrOfferList.count;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    OfferTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"OfferTableViewCell"];

    cell.loadingView.hidden = NO;
    NSString* imgUrl = arrOfferList[indexPath.row][@"offer"][@"offerPicture"];
    [cell.ivPic hnk_setImageFromURL:[NSURL URLWithString:imgUrl] placeholder:nil success:^(UIImage *image) {
        cell.loadingView.hidden = YES;
        cell.ivPic.image = image;
    } failure:^(NSError *error) {
        
    }];

    cell.lbTitle.text = arrOfferList[indexPath.row][@"offer"][@"offerTitle"];
    cell.lbDescription.text = arrOfferList[indexPath.row][@"merchant"][@"merchantName"];
    
    OFFERSTATUS status;
    @try {
        status = [arrOfferList[indexPath.row][@"offer"][@"offerStatus"] intValue];
    }
    @catch (NSException *exception) {
        status = OFFER_NONE;
    }
    @finally {
        
    }

    if (status == OFFER_ACCEPTED) {
        [cell.ivRedeem setImage:[UIImage imageNamed:@"ic_accepted.png"]];
    }
    else if (status == OFFER_REDEEMED) {
        [cell.ivRedeem setImage:[UIImage imageNamed:@"ic_redeemed.png"]];
    }
    else {
        [cell.ivRedeem setImage:[UIImage imageNamed:@"ic_closed.png"]];
    }
    
    return cell;
}
- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    
    [self performSegueWithIdentifier:@"gotoOfferDetail" sender:arrOfferList[indexPath.row]];
}
- (IBAction)onClickTest:(id)sender {
/*
 0 = “Unknown”
 1 = “Immediate”
 2 = “Near”
 3 = “Far”
*/
    URBAlertView *alertView = [[URBAlertView alloc] initWithTitle:@"Beacon TESTING"
                                                          message:@"Please choose any Beacon" ];
    [alertView addButtonWithTitle:@"FAR Beacon"];
    [alertView addButtonWithTitle:@"NEAR Beacon"];
    [alertView addButtonWithTitle:@"FAR Beacon"];
    [alertView addButtonWithTitle:@"Cancel"];

    [alertView setHandlerBlock:^(NSInteger buttonIndex, URBAlertView *alertView) {
        [alertView hideWithCompletionBlock:^{
            if (buttonIndex == 0) {
                dispatch_async(dispatch_get_main_queue(),^{
                    AppDelegate * appDelegate = [UIApplication sharedApplication].delegate;
//                    [appDelegate getOfferDetail:@"11111" BeaconProximityString:@"Far" BeaconProximityValue:[NSNumber numberWithInt:3]];
                });
            }
            if (buttonIndex == 1) {
                dispatch_async(dispatch_get_main_queue(),^{
                    AppDelegate * appDelegate = [UIApplication sharedApplication].delegate;
//                    [appDelegate getOfferDetail:@"22222" BeaconProximityString:@"Near" BeaconProximityValue:[NSNumber numberWithInt:2]];
                });
            }
            if (buttonIndex == 2) {
                dispatch_async(dispatch_get_main_queue(),^{
                    AppDelegate * appDelegate = [UIApplication sharedApplication].delegate;
//                    [appDelegate getOfferDetail:@"33333" BeaconProximityString:@"Far" BeaconProximityValue:[NSNumber numberWithInt:2]];
                });
            }

        }];
    }];
    [alertView show];
}

@end
