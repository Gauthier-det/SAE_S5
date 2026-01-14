import { apiClient } from "../utils/apiClient";
import type { TeamCreation, TeamMemberAdd, AvailableUser, TeamResponse } from "../models/team.model";

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
