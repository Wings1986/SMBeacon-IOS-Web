//
//  Global.m
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import "Global.h"

@implementation Global

+ (void) saveOfferList:(NSMutableArray*) arry
{
//    NSData *data = [NSKeyedArchiver archivedDataWithRootObject:arry];
//    [[NSUserDefaults standardUserDefaults] setObject:data forKey:@"offer_list"];
    [[NSUserDefaults standardUserDefaults] setObject:arry forKey:@"offer_list"];
    [[NSUserDefaults standardUserDefaults] synchronize];
}
+ (NSArray*) loadOfferList
{
//    NSData *newData = [[NSUserDefaults standardUserDefaults] objectForKey:@"offer_list"];
//    NSMutableArray *newArray = [NSKeyedUnarchiver unarchiveObjectWithData:newData];
    NSArray *newArray = [[NSUserDefaults standardUserDefaults] objectForKey:@"offer_list"];
    
    return newArray;
}

@end
