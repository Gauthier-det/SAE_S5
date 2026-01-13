import type { RaidCreation } from '../model/domain/raidModel';

export const createRaid = async (raid: RaidCreation): Promise<RaidCreation> => {
    return new Promise((resolve) => {
        setTimeout(() => {
            const newRaid: RaidCreation = raid;
            console.log('Raid created:', newRaid);
            resolve(newRaid);
        }, 1000);
    });
};
