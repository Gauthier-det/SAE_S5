import { apiClient } from "../utils/apiClient";
import type { TeamCreation, TeamMemberAdd, AvailableUser, TeamResponse } from "../models/team.model";
import type { TeamRaceDetails } from '../models/team-management.model';

export const createTeam = async (team: TeamCreation): Promise<number> => {
    const response = await apiClient<TeamResponse>('/teams', {
        method: 'POST',
        body: JSON.stringify(team)
    });
    return response.data.team_id;
};

export const addMemberToTeam = async (data: TeamMemberAdd): Promise<void> => {
    await apiClient('/teams/addMember', {
        method: 'POST',
        body: JSON.stringify(data)
    });
};

export const getAvailableUsersForRace = async (raceId: number): Promise<AvailableUser[]> => {
    const response = await apiClient<{ data: AvailableUser[] }>(`/races/${raceId}/available-users`);
    return response.data;
};

export const registerTeamToRace = async (teamId: number, raceId: number): Promise<void> => {
    await apiClient(`/teams/${teamId}/register-race`, {
        method: 'POST',
        body: JSON.stringify({ race_id: raceId })
    });
};

export const getTeamRaceDetailsApi = async (teamId: number, raceId: number): Promise<TeamRaceDetails> => {
    const response = await apiClient<TeamRaceDetails>(`/teams/${teamId}/races/${raceId}`);
    return response;
};

export const removeMemberFromTeamRace = async (teamId: number, raceId: number, userId: number): Promise<void> => {
    await apiClient('/teams/member/remove', {
        method: 'POST',
        body: JSON.stringify({ team_id: teamId, race_id: raceId, user_id: userId })
    });
};

export const updateMemberRaceInfo = async (
    teamId: number,
    raceId: number,
    userId: number,
    chipNumber?: string,
    pps?: string
): Promise<void> => {
    await apiClient('/teams/member/update-info', {
        method: 'POST',
        body: JSON.stringify({
            team_id: teamId,
            race_id: raceId,
            user_id: userId,
            chip_number: chipNumber,
            pps: pps
        })
    });
};

export const validateTeamForRace = async (teamId: number, raceId: number): Promise<void> => {
    await apiClient('/teams/validate-race', {
        method: 'POST',
        body: JSON.stringify({ team_id: teamId, race_id: raceId })
    });
};

export const unvalidateTeamForRace = async (teamId: number, raceId: number): Promise<void> => {
    await apiClient('/teams/unvalidate-race', {
        method: 'POST',
        body: JSON.stringify({ team_id: teamId, race_id: raceId })
    });
};
