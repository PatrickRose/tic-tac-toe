import { z } from 'zod';

// Manually write the types out
// We have two tables, and it's not really worth generating these automatically

export const gameStateDecode = z.union([
    z.literal('draw'),
    z.literal('in_progress'),
    z.literal('player_1'),
    z.literal('player_2'),
]);

export const userDecode = z.object({
    id: z.number(),
    name: z.string(),
    email: z.string(),
});

export const gameDecode = z.object({
    id: z.number(),
    player_1_id: z.number(),
    player_2_id: z.number().nullable(),
    moves: z.array(z.number()),
    player1: userDecode.optional(),
    player2: userDecode.optional(),
    game_state: gameStateDecode,
});

export type Game = z.infer<typeof gameDecode>;
export type User = z.infer<typeof userDecode>;
